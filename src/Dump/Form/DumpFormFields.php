<?php namespace Defr\BackupManagerModule\Dump\Form;

use Anomaly\Streams\Platform\Addon\AddonCollection;

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
        $connection = [
            'type'     => 'anomaly.field_type.select',
            'disabled' => true,
            'value'    => $builder->getDbConnection(),
            'options'  => [$builder->getDbConnection()],
        ];

        if ($builder->getForm()->getMode() !== 'edit')
        {
            return $builder->setFields([
                'title'         => 'anomaly.field_type.text',
                'addon'         => [
                    'type'   => 'anomaly.field_type.select',
                    'config' => [
                        'mode'          => 'search',
                        'default_value' => 'anomaly.module.pages',
                        'options'       => function (AddonCollection $addons)
                        {
                            return $addons->installed()->mapWithKeys(
                                function ($addon)
                                {
                                    return [
                                        $addon->getNamespace() => $addon->getName(),
                                    ];
                                }
                            )->toArray();
                        },
                    ],
                ],
                'db_connection' => $connection,
            ]);
        }

        $builder->setFields([
            'title',
            'path'          => [
                'disabled' => true,
            ],
            'addon'         => [
                'type'     => 'anomaly.field_type.select',
                'disabled' => true,
                'config'   => [
                    'mode'  => 'dropdown',
                    'value' => $builder->getFormEntry()->getAddon(),
                ],
            ],
            'db_connection' => $connection,
        ]);
    }
}
