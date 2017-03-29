<?php namespace Defr\BackupManagerModule\Dump\Command;

use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
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
    protected $database;
    protected $tables;
    protected $addon;

    /**
     * Create an instance fo MakeDump class
     *
     * @param string $database The database connection
     * @param string $tables   The tables
     * @param Addon  $addon    The addon
     */
    public function __construct($database, $tables, $addon)
    {
        $this->database = $database;
        $this->tables   = $tables;
        $this->addon    = $addon;
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
        $path   = base_path(env('DUMPS_PATH', 'dumps'));
        $date   = Carbon::now()->format('Y-m-d_H:i:s_');
        $tables = DB::select('SHOW TABLES');

        if (!$this->database)
        {
            $this->database = $config->get('database.default');
        }

        if ($this->tables)
        {
            $this->tables = explode(',', $this->tables);
        }

        if ($this->addon instanceof Module || $this->addon instanceof Extension)
        {

        }

        $db_name    = $config->get('database.connections.'.$this->database.'.database');
        $class_name = 'Tables_in_'.$db_name;

        $array = [];

        foreach ($tables as $table)
        {
            $array[$table->$class_name] = DB::select('SELECT * FROM '.$table->$class_name, [1]);
        }

        dd($array);

        if (!$files->exists($path))
        {
            $files->makeDirectory($path);
        }

        if (!$files->isDirectory($path))
        {
            return false;
        }

        $dump_file = $path.'/'.$date.$db_name.'_dump.sql.json';

        if ($files->put($dump_file, json_encode($array)))
        {
            return $dump_file;
        }
    }
}
