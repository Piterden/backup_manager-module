<?php namespace Defr\BackupManagerModule\Dump\Form;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Form builder class
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class DumpFormBuilder extends FormBuilder
{

    /**
     * Connection
     *
     * @var string
     */
    protected $db_connection;

    /**
     * Gets the connection.
     *
     * @return string The connection.
     */
    public function getDbConnection()
    {
        return $this->db_connection;
    }

    /**
     * Sets the connection.
     *
     * @param  string  $connection The connection
     * @return $this
     */
    public function setDbConnection($connection)
    {
        $this->db_connection = $connection;

        return $this;
    }
}
