<?php namespace Defr\BackupManagerModule\Dump;

use Anomaly\Streams\Platform\Entry\EntryPresenter;

class DumpPresenter extends EntryPresenter
{

    /**
     * Gets the presented path.
     *
     * @return string The path.
     */
    public function getName()
    {
        if (!$name = $this->object->getTitle())
        {
            $name = str_replace(
                base_path(env('DUMPS_PATH', 'dumps')).'/',
                '',
                $this->object->getPath()
            );
        }

        return "<h4>{$name}</h4>";
    }

    /**
     * Gets the size.
     *
     * @return string The size.
     */
    public function getSize()
    {
        $size = human_filesize($this->object->getSize());

        return "<h5>{$size}</h5>";
    }

    /**
     * Get a count of dumped tables
     *
     * @return string
     */
    public function tablesCount()
    {
        return count($this->object->getContent());
    }
}
