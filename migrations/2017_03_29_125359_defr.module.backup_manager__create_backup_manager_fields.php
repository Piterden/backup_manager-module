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
        'title'      => 'anomaly.field_type.text',
        'addon'      => 'anomaly.field_type.select',
        'path'       => 'anomaly.field_type.text',
        'connection' => 'anomaly.field_type.select',
    ];

}
