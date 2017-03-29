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
class WriteDump
{

    /**
     * Handle the command
     *
     * @param  Filesystem $files  The files
     * @param  Repository $config The configuration
     * @return string
     */
    public function handle(Filesystem $files, Repository $config)
    {
        $path    = env('DUMPS_PATH', base_path('dumps'));
        $date    = Carbon::now()->format('Y-m-d_H:i:s_');
        $tables  = DB::select('SHOW TABLES');
        $db_name = $config->get('database.connections.'
            .$config->get('database.default').'.database');
        $class_name = 'Tables_in_'.$db_name;
        $array      = [];

        foreach ($tables as $name => $table)
        {
            $array[$name] = DB::select('SELECT * FROM '.$table->$class_name, [1]);
        }

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
