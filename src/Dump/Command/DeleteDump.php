<?php namespace Defr\BackupManagerModule\Dump\Command;

use Anomaly\Streams\Platform\Message\MessageBag;
use Illuminate\Filesystem\Filesystem;

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
    public function handle(Filesystem $files, MessageBag $messages)
    {
        if (!$files->exists($this->path))
        {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($messages->error('Dump file not found!'));
        }

        if (!$files->delete([$this->path]))
        {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($messages->error('Can\'t remove dump!'));
        }

        return redirect()
            ->back()
            ->withInput()
            ->withErrors($messages->success('Dump deleted successfully.'));
    }
}
