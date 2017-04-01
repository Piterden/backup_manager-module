<?php namespace Defr\BackupManagerModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Defr\BackupManagerModule\Dump\Command\LoadInfo;
use Defr\BackupManagerModule\Dump\Contract\DumpRepositoryInterface;
use Defr\BackupManagerModule\Dump\Form\DumpFormBuilder;
use Defr\BackupManagerModule\Dump\Table\DumpTableBuilder;
use Illuminate\Contracts\Config\Repository;

/**
 * Dumps admin controller
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
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
        $form->setDbConnection($this->request->get('db_connection'));

        return $form->render();
    }

    /**
     * Create a new entry.
     *
     * @param  DumpFormBuilder $form
     * @param  Repository      $config The configuration
     * @return Response
     */
    public function choose(DumpFormBuilder $form, Repository $config)
    {
        $connections = $config->get('database.connections');

        return view(
            'defr.module.backup_manager::admin/dumps/choose_connection',
            compact('connections')
        );
    }

    /**
     * Edit an existing entry.
     *
     * @param  DumpRepositoryInterface $dumps  The dumps
     * @param  DumpFormBuilder         $form
     * @param  int                     $id
     * @return Response
     */
    public function edit(DumpRepositoryInterface $dumps, DumpFormBuilder $form, $id)
    {
        $entry = $dumps->find($id);

        $form->setDbConnection($entry->getDbConnection());

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

    /**
     * Restore a dump
     *
     * @param  DumpTableBuilder $table The table
     * @param  int              $id    The identifier
     * @return Response
     */
    public function restore(DumpTableBuilder $table, $id)
    {
        return $table->restore($id);
    }
}
