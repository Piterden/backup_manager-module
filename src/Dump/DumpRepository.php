<?php namespace Defr\BackupManagerModule\Dump;

use Anomaly\Streams\Platform\Entry\EntryRepository;
use Defr\BackupManagerModule\Dump\Contract\DumpRepositoryInterface;

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
     * @param array $files The files
     */
    public function sync(array $files)
    {
        $filesEntries = collect($files);
        $dbEntries    = $this->model->get()->mapWithKeys(function ($entry)
        {
            return [$entry->getPath() => $entry];
        });

        $deletingEntries = $dbEntries->diffKeys($filesEntries)->toArray();
        $creatingEntries = $filesEntries->diffKeys($dbEntries)->toArray();

        foreach ($creatingEntries as $path => $file)
        {
            /* @var DumpInterface $entry */
            $entry = $this->create(array_except($file, ['content']));
            $entry->setContent(
                array_get($file, 'content')
            );
        }

        foreach ($deletingEntries as $path => $model)
        {
            $entry = $dbEntries->get($path);

            $entry->delete();
        }

        return $this->model->get();
    }
}
