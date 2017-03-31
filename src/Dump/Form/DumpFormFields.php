<?php namespace Defr\BackupManagerModule\Dump\Form;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Illuminate\Config\Repository;

/**
 * Class for handle dump form fields
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class DumpFormFields
{

    /**
     * Handle form fields
     *
     * @param DumpFormBuilder $builder The builder
     */
    public function handle(DumpFormBuilder $builder)
    {
        $fields = [
            'title',
            'addon'      => [
                'config' => [
                    'mode'          => 'search',
                    'default_value' => 'anomaly.module.pages',
                    'options'       => function (AddonCollection $addons)
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
            // 'connection' => [
            //     'config' => [
            //         'mode'          => 'search',
            //         'default_value' => 'mysql',
            //         'options'       => function (Repository $config)
            //         {
            //             $connections = array_keys($config->get('database.connections'));

            //             return array_combine($connections, $connections);
            //         },
            //     ],
            // ],
        ];

        if ($builder->getForm()->getMode() == 'edit')
        {
            $fields['path'] = [
                'disabled' => true,
            ];
// dd($builder->getFormEntry()->);
            $fields['addon']['disabled'] = true;
            $fields['addon']['value'] = $builder->getFormEntry()->getAddon();
        }

        $builder->setFields($fields);
    }
}
