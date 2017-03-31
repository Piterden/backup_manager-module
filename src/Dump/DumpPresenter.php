<?php namespace Defr\BackupManagerModule\Dump;

use Anomaly\Streams\Platform\Addon\Command\GetAddon;
use Anomaly\Streams\Platform\Entry\EntryPresenter;

/**
 * Dump presenter class
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class DumpPresenter extends EntryPresenter
{

    /**
     * Gets the presented path.
     *
     * @return string The path.
     */
    public function getFileName()
    {
        return array_get(array_reverse(explode('/', $this->object->getPath())), 0);
    }

    /**
     * Gets the size.
     *
     * @return string The size.
     */
    public function getSize()
    {
        return human_filesize($this->object->getSize());
    }

    /**
     * Gets the addon name.
     *
     * @return string The addon name.
     */
    public function getAddonName()
    {
        return trans($this->dispatch(
            new GetAddon($this->object->getAddon())
        )->getName());
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
