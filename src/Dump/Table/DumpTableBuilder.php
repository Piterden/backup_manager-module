<?php namespace Defr\BackupManagerModule\Dump\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Defr\BackupManagerModule\Dump\Command\DeleteDump;
use Defr\BackupManagerModule\Dump\Command\GetDumps;
use Defr\BackupManagerModule\Dump\Command\RestoreDump;

/**
 * Class for building a table
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class DumpTableBuilder extends TableBuilder
{

    /**
     * The table columns.
     *
     * @var array|string
     */
    protected $columns = [
        'title'              => [
            'wrapper' => '<h5>{value}</h5>',
        ],
        'path'               => [
            'heading' => 'module::table.filename.name',
            'value'   => 'entry.file_name',
            'wrapper' => '<strong>{value}</strong>',
        ],
        'addon'              => [
            'value'   => 'entry.addon_name',
            'wrapper' => '<strong>{value}</strong>',
        ],
        'entry.size'         => [
            'wrapper' => '<h6>{value}</h6>',
        ],
        'entry.tables_count' => [
            'heading' => 'module::table.count.name',
            'wrapper' => '<center>{value}</center>',
        ],
        'created_at'         => [
            'value' => 'entry.created_at_datetime',
        ],
    ];

    /**
     * The table buttons.
     *
     * @var array|string
     */
    protected $buttons = [
        'restore'     => [
            'href' => 'admin/backup_manager/restore/{entry.id}',
        ],
        'information' => [
            'data-toggle' => 'modal',
            'data-target' => '#modal-wide',
            'href'        => 'admin/backup_manager/info/{entry.id}',
        ],
        'edit',
        'delete'      => [
            'href' => 'admin/backup_manager/delete/{entry.id}',
        ],
    ];

    /**
     * Delete the dump entry
     *
     * @param  int       $id The identifier
     * @return Reponse
     */
    public function delete($id)
    {
        $entry = $this->getEntryById($id);

        return $this->dispatch(new DeleteDump($entry->getPath()));
    }

    /**
     * Restore dump to DB
     *
     * @param  int        $id The identifier
     * @return Response
     */
    public function restore($id)
    {
        $entry = $this->getEntryById($id);

        return $this->dispatch(new RestoreDump($entry->getPath()));
    }

    /**
     * Gets the entry by identifier.
     *
     * @param  int           $id The identifier
     * @return DumpInterface The entry by identifier.
     */
    private function getEntryById($id)
    {
        return $this->dispatch(new GetDumps())->first(
            function ($entry) use ($id)
            {
                return $entry->id == $id;
            }
        );
    }
}
