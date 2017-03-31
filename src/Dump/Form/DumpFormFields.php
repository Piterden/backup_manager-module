<?php namespace Defr\BackupManagerModule\Dump\Form;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Illuminate\Config\Repository;

class DumpFormFields
{

    public function handle(DumpFormBuilder $builder)
    {
        $builder->setFields([
            'title',
            'addon'    => [
                'config' => [
                    'mode' => 'search',
                    'options' => function (AddonCollection $addons)
                    {
                        return $addons->installed()->mapWithKeys(
                            function ($addon)
                            {
                                return [$addon->getNamespace() => $addon->getName()];
                            }
                        )->toArray();
                    },
                ],
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
        ]);
    }
}
