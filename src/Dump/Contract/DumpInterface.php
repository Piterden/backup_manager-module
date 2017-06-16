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
     * Sets the path.
     *
     * @return string The path.
     */
    public function setPath($path);

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
     * Sets the content.
     *
     * @param  string  $content The content
     * @return $this
     */
    public function setContent($content);

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

    /**
     * Gets the database connection.
     *
     * @return string The database connection.
     */
    public function getDbConnection();

    /**
     * Sets the database connection.
     *
     * @param  string  The database connection.
     * @return $this
     */
    public function setDbConnection($db_connection);

    /**
     * Gets the default database connection.
     *
     * @return string The default database connection.
     */
    public function getDefaultDbConnection();
}
