<?php namespace Defr\BackupManagerModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

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
            ],
        ],
    ];
}
