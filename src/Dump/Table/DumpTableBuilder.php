<?php namespace Defr\BackupManagerModule\Dump\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Defr\BackupManagerModule\Dump\Command\GetDumps;
use Defr\BackupManagerModule\Dump\Command\DeleteDump;

class DumpTableBuilder extends TableBuilder
{

    /**
     * The table columns.
     *
     * @var array|string
     */
    protected $columns = [
        'path' => [
            'value' => 'entry.get_path',
        ],
    ];

    /**
     * The table buttons.
     *
     * @var array|string
     */
    protected $buttons = [
        'delete' => [
            'href' => 'admin/backup_manager/delete/{entry.id}',
        ],
    ];

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The table assets.
     *
     * @var array
     */
    protected $assets = [];

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
