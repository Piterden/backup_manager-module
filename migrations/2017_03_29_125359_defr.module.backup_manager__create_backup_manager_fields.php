<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class DefrModuleBackupManagerCreateBackupManagerFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'title' => 'anomaly.field_type.text',
        'addon' => 'anomaly.field_type.addon',
        'path'  => 'anomaly.field_type.text',
    ];

}
