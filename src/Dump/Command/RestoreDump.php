<?php namespace Defr\BackupManagerModule\Dump\Command;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

/**
 * Class for delete dump from the filesystem
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class RestoreDump
{

    /**
     * The path of file
     *
     * @var mixed
     */
    protected $path;

    /**
     * The application
     *
     * @var Application
     */
    protected $app;

    /**
     * Create an instance of RestoreDump class
     *
     * @param mixed $path The path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->app  = app(Application::class);
    }

    /**
     * Handle the command
     *
     * @param  Filesystem $files The files
     * @return string
     */
    public function handle(Filesystem $files)
    {
        if ($files->exists($this->path))
        {
            if ($dupm_data = json_decode($files->get($this->path), true))
            {
                $app_ref = $this->app->getReference();

                foreach ($dupm_data as $table_name => $table_rows)
                {
                    $table_name = str_replace($app_ref.'_', '', $table_name);

                    DB::table($table_name)->truncate();

                    foreach ($table_rows as $row_index => $row_data)
                    {
                        DB::table($table_name)->insert($row_data);
                    }
                }
            }
        }

        return redirect()->back()->withInput();
    }
}
