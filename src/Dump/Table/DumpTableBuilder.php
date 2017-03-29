<?php namespace Defr\BackupManagerModule\Dump\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Defr\BackupManagerModule\Dump\Command\DeleteDump;
use Defr\BackupManagerModule\Dump\Command\GetDumps;

class DumpTableBuilder extends TableBuilder
{

    /**
     * The table columns.
     *
     * @var array|string
     */
    protected $columns = [
        'entry.id',
        'path' => [
            'heading' => 'module::field.title.name',
            'value'   => 'entry.name',
        ],
        'entry.size',
        'entry.created_at',
    ];

    /**
     * The table buttons.
     *
     * @var array|string
     */
    protected $buttons = [
        'information' => [
            'data-toggle' => 'modal',

        ],
        'edit',
        'delete' => [
            'href' => 'admin/backup_manager/delete/{entry.id}',
        ],
    ];

    public function delete($id)
    {
        /* @var DumpCollection $entries */
        $entries = $this->dispatch(new GetDumps());

        $entry = $entries->first(function ($entry) use ($id)
        {
            return $entry->id == $id;
        });

        return $this->dispatch(new DeleteDump($entry->getPath()));
    }

}
