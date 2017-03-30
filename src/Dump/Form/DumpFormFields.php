<?php namespace Defr\BackupManagerModule\Dump\Form;

use Illuminate\Config\Repository;

class DumpFormFields
{

    public function handle(DumpFormBuilder $builder)
    {
        $builder->setFields([
            'title',
            'addon'    => [
                'type'  => 'anomaly.field_type.addon',
                'label' => 'module::field.addon.name',
            ],
            'database' => [
                'type'   => 'anomaly.field_type.select',
                'label'  => 'module::field.database.name',
                'config' => [
                    'default_value' => 'mysql',
                    'options'       => function (Repository $config)
                    {
                        $array = array_keys($config->get('database.connections'));

                        return array_combine($array, $array);
                    },
                ],
            ],
            'path',
        ]);
    }
}
