<?php namespace Defr\BackupManagerModule\Dump\Command;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Stream\Command\GetStreams;
use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;

/**
 * Class for write the dump to filesystem
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class MakeDump
{
    use DispatchesJobs;

    /**
     * Database to work with
     *
     * @var string
     */
    protected $database;

    /**
     * Tables to dump
     *
     * @var string
     */
    protected $tables;

    /**
     * Addon to dump
     *
     * @var Addon
     */
    protected $addon;

    /**
     * App instance
     *
     * @var Application
     */
    protected $app;

    /**
     * Create an instance fo MakeDump class
     *
     * @param string $database The database connection
     * @param string $tables   The tables
     * @param Addon  $addon    The addon
     */
    public function __construct($database = '', $tables = '', $addon = null)
    {
        $this->database = $database;
        $this->tables   = $tables;
        $this->addon    = $addon;
        $this->app      = app(Application::class);
    }

    /**
     * Handle the command
     *
     * @param  Filesystem $files  The files
     * @param  Repository $config The configuration
     * @return string
     */
    public function handle(Filesystem $files, Repository $config)
    {
        $dumpPath = base_path(env('DUMPS_PATH', 'dumps'));
        $date     = Carbon::now()->format(env('DUMP_FORMAT', 'Y-m-d_H:i:s_'));
        $tables   = DB::select('SHOW TABLES');

        if (!$database = $this->database)
        {
            $database = $config->get('database.default');
        }

        $includedTables = [];
        $db_name        = $config->get('database.connections.'.$database.'.database');
        $class_name     = 'Tables_in_'.$db_name;
        $appReference   = $this->app->getReference();

        if ($this->tables)
        {
            $includedTables = array_merge(
                $includedTables,
                explode(',', $this->tables)
            );
        }

        if ($this->addon)
        {
            $slug = $this->addon->getSlug();
            $path = $this->addon->getPath();

            $migrations = $files->glob($path.'/migrations/*');

            if (count($migrations) > 0)
            {
                foreach ($tables as $table)
                {
                    if (starts_with($table->$class_name, $appReference.'_'.$slug.'_'))
                    {
                        $includedTables[] = $table->$class_name;
                    }
                }
            }
        }

        if (count($includedTables))
        {
            $tables = $includedTables;
        }

        $array = [];

        foreach ($tables as $table)
        {
            if (is_object($table))
            {
                $table = $table->$class_name;
            }

            $table = trim($table);

            if (!starts_with($table, $appReference.'_') && !starts_with($table, 'applications'))
            {
                $table = $appReference.'_'.$table;
            }

            $array[$table] = DB::select('SELECT * FROM '.$table, [1]);
        }

        if (!$files->exists($dumpPath))
        {
            $files->makeDirectory($dumpPath);
        }

        if (!$files->isDirectory($dumpPath))
        {
            return false;
        }

        $dump_file = $dumpPath.'/'.$date.$db_name.'_dump.sql.json';

        if ($files->put($dump_file, json_encode($array)))
        {
            return $dump_file;
        }
    }

    /**
     * Gets the root streams of addon.
     *
     * @param  string             $slug The addon slug
     * @return StreamCollection
     */
    public function getStreams($slug)
    {
        return $this->dispatch(new GetStreams($slug))->filter(
            function ($stream)
            {
                return !str_contains($stream->getSlug(), '_');
            }
        );
    }
}
