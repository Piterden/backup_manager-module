<?php namespace Defr\BackupManagerModule\Dump\Command;

use Defr\BackupManagerModule\Dump\Contract\DumpRepositoryInterface;
use Illuminate\Filesystem\Filesystem;

/**
 * Class for get dumps from the filesystem
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class GetDumps
{

    /**
     * Handle the command
     *
     * @param  Filesystem              $files The files
     * @param  DumpRepositoryInterface $dumps The dumps
     * @return DumpCollection
     */
    public function handle(Filesystem $files, DumpRepositoryInterface $dumps)
    {
        $path    = base_path(env('DUMPS_PATH', 'dumps'));
        $list    = $files->glob($path.'/*sql.json');
        $id      = 1;
        $entries = [];

        foreach ($list as $path)
        {
            /* @var DumpInterface $entry */
            $entry = [
                'path'    => $path,
                'content' => json_decode($files->get($path), true),
            ];

            $entries[$path] = $entry;
        }

        return $dumps->sync($entries);
    }
}
