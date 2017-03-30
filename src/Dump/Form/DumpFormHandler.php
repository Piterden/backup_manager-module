<?php namespace Defr\BackupManagerModule\Dump\Form;

use Defr\BackupManagerModule\Dump\Command\MakeDump;
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
        $entry    = $builder->getFormEntry();
        $addon    = $builder->getForm()->getValue('addon');
        $database = $builder->getForm()->getValue('database');

        if (!$entry->getPath())
        {
            if ($path = $this->dispatch(new MakeDump($database, null, $addon)))
            {
                $entry->setPath($path);
            }
        }

        $builder->getForm()->removeField('addon')->removeField('database');
    }
}
