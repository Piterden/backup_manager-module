<?php namespace Defr\BackupManagerModule\Dump\Command;

use Anomaly\Streams\Platform\Message\MessageBag;
use Defr\BackupManagerModule\Dump\Contract\DumpRepositoryInterface;
use Illuminate\Filesystem\Filesystem;

/**
 * Class for load info about dump
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class LoadInfo
{

    /**
     * The path of file
     *
     * @var mixed
     */
    protected $id;

    /**
     * Create an instance of LoadInfo class
     *
     * @param mixed $id The identifier
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Handle the command
     *
     * @param  Filesystem              $files    The files
     * @param  MessageBag              $messages The messages
     * @param  DumpRepositoryInterface $dumps    The dumps
     * @return Response
     */
    public function handle(
        Filesystem $files,
        MessageBag $messages,
        DumpRepositoryInterface $dumps
    )
    {
        if (!$dump = $dumps->find($this->id))
        {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($messages->error('Dump entry not found!'));
        }

        return view(
            'defr.module.backup_manager::admin/dumps/info',
            [
                'dump' => $dump,
            ]
        );
    }
}
