<?php namespace Defr\BackupManagerModule\Dump\Command;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;

/**
 * Class for delete dump from the filesystem
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class DeleteDump
{

    /**
     * The path of file
     *
     * @var mixed
     */
    protected $path;

    /**
     * Create an instance of DeleteDump class
     *
     * @param mixed $path The path
     */
    public function __construct($path)
    {
        $this->path = $path;
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
            $files->delete([$this->path]);
        }

        return redirect()->back()->withInput();
    }
}
