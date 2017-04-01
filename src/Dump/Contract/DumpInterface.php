<?php namespace Defr\BackupManagerModule\Dump\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

interface DumpInterface extends EntryInterface
{

    /**
     * Gets the identifier.
     *
     * @return int The identifier.
     */
    public function getId();

    /**
     * Gets the title.
     *
     * @return string The title.
     */
    public function getTitle();

    /**
     * Gets the path.
     *
     * @return string The path.
     */
    public function getPath();

    /**
     * Gets the addon.
     *
     * @return string The addon.
     */
    public function getAddon();

    /**
     * Gets the size.
     *
     * @return string The size.
     */
    public function getSize();

    /**
     * Gets the content.
     *
     * @return string The content.
     */
    public function getContent();

    /**
     * Gets the content.
     *
     * @return string The content.
     */
    public function getDbConnection();

    /**
     * Gets the created on.
     *
     * @return <type> The created on.
     */
    public function getCreatedAt();

    /**
     * Gets the updated on.
     *
     * @return <type> The updated on.
     */
    public function getUpdatedAt();
}
