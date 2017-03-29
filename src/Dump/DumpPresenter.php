<?php namespace Defr\BackupManagerModule\Dump;

use Anomaly\Streams\Platform\Entry\EntryPresenter;

class DumpPresenter extends EntryPresenter
{

    /**
     * Gets the presented path.
     *
     * @return     <type>  The path.
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
        $size = $this->object->getSize() / 1000;

        return "<h5>{$size} KB</h5>";
    }
}
