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
     * @param  array            $files The files
     * @return DumpCollection
     */
    public function sync(array $files);

    /**
     * Creates entries.
     *
     * @param array $entries The entries
     */
    public function createEntries(array $entries);

    /**
     * Delete entries.
     *
     * @param array $entries The entries
     */
    public function deleteEntries(array $entries);

    /**
     * Gets the database entries.
     *
     * @return DumpCollection The database entries.
     */
    public function getDbEntries();
}
