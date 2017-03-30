<?php namespace Defr\BackupManagerModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Defr\BackupManagerModule\Dump\Command\LoadInfo;
use Defr\BackupManagerModule\Dump\Form\DumpFormBuilder;
use Defr\BackupManagerModule\Dump\Table\DumpTableBuilder;

class DumpsController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param  DumpTableBuilder $table
     * @return Response
     */
    public function index(DumpTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param  DumpFormBuilder $form
     * @return Response
     */
    public function create(DumpFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param  DumpFormBuilder $form
     * @param  $id
     * @return Response
     */
    public function edit(DumpFormBuilder $form, $id)
    {
        return $form->render($id);
    }

    /**
     * Information about an existing entry.
     *
     * @param  DumpFormBuilder $form
     * @param  $id
     * @return Response
     */
    public function info($id)
    {
        return $this->dispatch(new LoadInfo($id));
    }

    /**
     * Delete an entry
     *
     * @param  DumpTableBuilder $table The table
     * @param  mixed            $id    The identifier
     * @return Response
     */
    public function delete(DumpTableBuilder $table, $id)
    {
        return $table->delete($id);
    }
}
