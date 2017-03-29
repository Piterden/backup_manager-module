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
     * Sets the title.
     *
     * @param  string  $title The title
     * @return string The title.
     */
    public function setTitle($title);

    /**
     * Gets the path.
     *
     * @return string The path.
     */
    public function getPath();

    /**
     * Sets the path.
     *
     * @param  string  $path The path
     * @return string The path.
     */
    public function setPath($path);

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
}
