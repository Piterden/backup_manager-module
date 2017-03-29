<?php namespace Defr\BackupManagerModule\Dump\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;

interface DumpRepositoryInterface extends EntryRepositoryInterface
{

    /**
     * Find by path in DB
     *
     * @param  string          $path The path
     * @return DumpInterface
     */
    public function findByPath($path);

    /**
     * Sync DB with real FS files
     *
     * @param array $files The files
     */
    public function sync(array $files);
}
