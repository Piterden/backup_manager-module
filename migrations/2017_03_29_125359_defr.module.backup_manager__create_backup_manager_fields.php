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
        'path'  => 'anomaly.field_type.text',
    ];

}