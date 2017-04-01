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
        $fields = [
            'title',
            'addon'         => [
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
            'db_connection' => [
                'type'     => 'anomaly.field_type.select',
                'disabled' => true,
                'value'    => $builder->getDbConnection(),
                'options'  => [
                    $builder->getDbConnection(),
                ],
            ],
        ];

        if ($builder->getForm()->getMode() == 'edit')
        {
            $builder->setFields(array_merge($fields, [
                'path'  => [
                    'disabled' => true,
                ],
                'addon' => array_merge(
                    array_get($fields, 'addon'),
                    array_merge(
                        array_get($fields, 'addon.config'),
                        [
                            'disabled' => true,
                            'mode'     => 'dropdown',
                            'value'    => $builder->getFormEntry()->getAddon(),
                        ]
                    )
                ),
            ]));

            return;
        }

        $builder->setFields($fields);
    }
}
