<?php namespace Defr\BackupManagerModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

/**
 * Module class
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class BackupManagerModule extends Module
{

    /**
     * The addon icon.
     *
     * @var string
     */
    protected $icon = 'fa fa-database';

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [
        'dumps' => [
            'buttons' => [
                'new_dump',
                'change' => [
                    'text'        => 'defr.module.backup_manager::button.change',
                    'href'        => 'admin/backup_manager/choose',
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                ],
            ],
        ],
    ];
}
