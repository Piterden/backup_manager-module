<?php namespace Defr\BackupManagerModule\Dump;

use Anomaly\Streams\Platform\Model\BackupManager\BackupManagerDumpsEntryModel;
use Defr\BackupManagerModule\Dump\Contract\DumpInterface;

/**
 * Dump model class
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class DumpModel extends BackupManagerDumpsEntryModel implements DumpInterface
{

    /**
     * The content.
     *
     * @var string
     */
    protected $content;

    /**
     * Gets the identifier.
     *
     * @return int The identifier.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the title.
     *
     * @return string The title.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Gets the path.
     *
     * @return string The path.
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the path.
     *
     * @return string The path.
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Gets the addon.
     *
     * @return string The addon.
     */
    public function getAddon()
    {
        return $this->addon;
    }

    /**
     * Gets the size.
     *
     * @return string The size.
     */
    public function getSize()
    {
        return filesize($this->getPath());
    }

    /**
     * Gets the content.
     *
     * @return string The content.
     */
    public function getContent()
    {
        return json_decode(file_get_contents($this->getPath()), true);
    }

    /**
     * Sets the content.
     *
     * @param  string  $content The content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Gets the created on.
     *
     * @return <type> The created on.
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Gets the updated on.
     *
     * @return <type> The updated on.
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Gets the database connection.
     *
     * @return string The database connection.
     */
    public function getDbConnection()
    {
        return $this->db_connection;
    }

    /**
     * Sets the database connection.
     *
     * @param  string  The database connection.
     * @return $this
     */
    public function setDbConnection($db_connection)
    {
        $this->db_connection = $db_connection;

        return $this;
    }
}
