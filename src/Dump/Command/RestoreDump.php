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
            if ($dupmData = json_decode($files->get($this->path), true))
            {
                $appReference = $this->app->getReference();

                foreach ($dupmData as $tableName => $tableRows)
                {
                    $tableName = str_replace($appReference.'_', '', $tableName);

                    DB::table($tableName)->truncate();

                    foreach ($tableRows as $rowData)
                    {
                        DB::table($tableName)->insert($rowData);
                    }
                }
            }
        }

        return redirect()->back()->withInput();
    }
}
