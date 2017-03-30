<?php namespace Defr\BackupManagerModule\Dump\Form;

use Illuminate\Config\Repository;

class DumpFormHandler
{

    /**
     * Handle the form
     *
     * @param      DumpFormBuilder  $builder  The builder
     */
    public function handle(DumpFormBuilder $builder)
    {
        $addon = $builder->getForm()->getValue('addon');

        $builder->getForm()->removeField('addon')->removeField('database');
    }
}
