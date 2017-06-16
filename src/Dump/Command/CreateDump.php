<?php namespace Defr\BackupManagerModule\Dump\Command;

use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Command\GetAddon;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Stream\Command\GetStreams;
use Carbon\Carbon;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;

/**
 * Class for create dump in the filesystem
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class CreateDump
{
    use DispatchesJobs;

    /**
     * Connection to work with
     *
     * @var string
     */
    protected $dbConnection;

    /**
     * Tables to dump
     *
     * @var string
     */
    protected $tables;

    /**
     * Addon to dump
     *
     * @var Addon|string
     */
    protected $addon;

    /**
     * App instance
     *
     * @var Application
     */
    protected $app;

    /**
     * Create an instance fo CreateDump class
     *
     * @param null|string       $dbConnection DB db_connection
     * @param null|string       $tables       The tables
     * @param null|Addon|string $addon        The addon
     */
    public function __construct($dbConnection = null, $tables = null, $addon = null)
    {
        $this->dbConnection = $dbConnection;
        $this->tables       = $tables;
        $this->app          = app(Application::class);

        if (is_object($addon))
        {
            $this->addon = $addon;
        }

        if (is_string($addon))
        {
            $this->addon = $this->dispatch(new GetAddon($addon));
        }
    }

    /**
     * Handle the command
     *
     * @param  Filesystem                 $files    The files
     * @param  Repository                 $config   The configuration
     * @param  SettingRepositoryInterface $settings The settings
     * @return null|string                Path of made file
     */
    public function handle(
        Filesystem $files,
        Repository $config,
        SettingRepositoryInterface $settings
    )
    {
        $dumpPath = base_path(env(
            'DUMPS_PATH',
            $settings->value(
                'defr.module.backup_manager::dump_path',
                'dumps'
            )
        ));

        $date = Carbon::now()->format(env(
            'DUMP_FORMAT',
            $settings->value(
                'defr.module.backup_manager::dump_format',
                'Y-m-d_H:i:s_'
            )
        ));

        $tables = DB::select('SHOW TABLES');

        $includedTables = [];
        $dbConnection   = $this->dbConnection ?: $config->get('database.default');
        $dbName         = $config->get("database.connections.{$dbConnection}.database");
        $className      = "Tables_in_{$dbName}";
        $appReference   = $this->app->getReference();

        if (is_string($this->tables))
        {
            $this->tables = explode(',', $this->tables);
        }

        $includedTables = array_merge($includedTables, $this->tables);

        if ($this->addon)
        {
            $slug = $this->addon->getSlug();
            $path = $this->addon->getPath();

            if (count($files->glob("{$path}/migrations/*")) > 0)
            {
                foreach ($tables as $table)
                {
                    if (starts_with(
                        $table->$className,
                        "{$appReference}_{$slug}_"
                    ))
                    {
                        $includedTables[] = $table->$className;
                    }
                }
            }
        }

        if (count($includedTables))
        {
            $tables = $includedTables;
        }

        $dump = [];

        foreach ($tables as $table)
        {
            if (is_object($table))
            {
                $table = $table->$className;
            }

            $table = trim($table);

            if (!starts_with($table, "{$appReference}_")
                && !starts_with($table, 'applications'))
            {
                $table = "{$appReference}_{$table}";
            }

            array_set(
                $dump,
                $table,
                DB::select('SELECT * FROM ' . $table, [1])
            );
        }

        if (!$files->exists($dumpPath))
        {
            $files->makeDirectory($dumpPath);
        }

        if (!$files->isDirectory($dumpPath))
        {
            $messages->error('Can\'t create directory!');

            return false;
        }

        $dumpFile = "{$dumpPath}/{$date}{$dbName}_dump.sql.json";

        if (!$files->put($dumpFile, json_encode($dump, true)))
        {
            $messages->error('Can\'t create file!');

            return false;
        }

        return $dumpFile;
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
            function (StreamInterface $stream)
            {
                return !str_contains($stream->getSlug(), '_');
            }
        );
    }
}
