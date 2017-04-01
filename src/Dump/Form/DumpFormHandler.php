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
            return;
        }

        $entry = $builder->getFormEntry();

        $connection = $builder->getDbConnection();

        if ($builder->getForm()->getMode() == 'create')
        {
            $addon = $builder->getFormValue('addon');

            if ($path = $this->dispatch(new CreateDump($connection, null, $addon)))
            {
                $entry->setPath($path);
                $entry->setDbConnection($connection);

                $entry->save();
            }
        }

        $builder->saveForm();
    }
}
