<?php namespace Defr\BackupManagerModule\Dump\Form;

use Defr\BackupManagerModule\Dump\Command\CreateDump;
use Illuminate\Foundation\Bus\DispatchesJobs;

class DumpFormHandler
{
    use DispatchesJobs;

    /**
     * Handle the form
     *
     * @param DumpFormBuilder $builder The builder
     */
    public function handle(DumpFormBuilder $builder)
    {
        if (!$builder->canSave())
        {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($messages->error('You are not allowed to save entry!'));
        }

        if ($builder->getFormMode() !== 'create')
        {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($messages->error('You can\'t edit dumps!'));
        }

        if (!$addon = $builder->getFormValue('addon'))
        {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($messages->error('Please, set the addon!'));
        }

        /* @var EntryInterface $entry */
        $entry      = $builder->getFormEntry();
        $connection = $builder->getDbConnection();

        if ($path = $this->dispatch(new CreateDump($connection, null, $addon)))
        {
            $entry->setPath($path);
            $entry->setDbConnection($connection);
            $entry->save();
        }

        $builder->saveForm();
    }
}
