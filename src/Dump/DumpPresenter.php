<?php namespace Defr\BackupManagerModule\Dump;

use Anomaly\Streams\Platform\Entry\EntryPresenter;

class DumpPresenter extends EntryPresenter
{

    /**
     * Gets the path presented.
     *
     * @return     <type>  The path.
     */
    public function getPath()
    {
        $name = str_replace(
            base_path(env('DUMPS_PATH', 'dumps')).'/',
            '',
            $this->object->getPath()
        );

        return "<h4>{$name}</h4>";
    }
}
