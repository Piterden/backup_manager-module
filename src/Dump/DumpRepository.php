<?php namespace Defr\BackupManagerModule\Dump;

use Anomaly\Streams\Platform\Entry\EntryRepository;
use Defr\BackupManagerModule\Dump\Contract\DumpInterface;
use Defr\BackupManagerModule\Dump\Contract\DumpRepositoryInterface;

/**
 * Dump repository class
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class DumpRepository extends EntryRepository implements DumpRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var ApiModel
     */
    protected $model;

    /**
     * Create a new ApiRepository instance.
     *
     * @param ApiModel $model
     */
    public function __construct(DumpModel $model)
    {
        $this->model = $model;
    }

    /**
     * Find by path in DB
     *
     * @param  string          $path The path
     * @return DumpInterface
     */
    public function findByPath($path)
    {
        return $this->model->where('path', $path)->first();
    }

    /**
     * Sync DB with real FS files
     *
     * @param  array            $files The files
     * @return DumpCollection
     */
    public function sync(array $files)
    {
        /* @var Collection $filesEntries */
        $filesEntries = collect($files);

        /* @var DumpCollection $dbEntries */
        $dbEntries = $this->getDbEntries();

        $this->deleteEntries($dbEntries->diffKeys($filesEntries)->toArray());
        $this->createEntries($filesEntries->diffKeys($dbEntries)->toArray());

        return $this->model->get();
    }

    /**
     * Creates entries.
     *
     * @param array $entries The entries
     */
    protected function createEntries(array $entries)
    {
        foreach ($entries as $path => $file)
        {
            /* @var DumpInterface $entry */
            if (!$entry = $this->create(array_except($file, ['content'])))
            {
                throw new \Exception('Error create entry!', 1);
            }

            $entry->setContent(array_get($file, 'content'));
        }
    }

    /**
     * Delete entries.
     *
     * @param array $entries The entries
     */
    protected function deleteEntries(array $entries)
    {
        foreach ($entries as $path => $model)
        {
            /* @var DumpInterface $entry */
            if (!$entry = $this->getDbEntries()->get($path))
            {
                throw new \Exception('Error entry not found!', 1);
            }

            $entry->delete();
        }
    }

    /**
     * Gets the database entries.
     *
     * @return DumpCollection The database entries.
     */
    protected function getDbEntries()
    {
        return $this->model->get()->mapWithKeys(
            /* @var DumpInterface $entry */
            function (DumpInterface $entry)
            {
                return [
                    $entry->getPath() => $entry,
                ];
            }
        );
    }
}
