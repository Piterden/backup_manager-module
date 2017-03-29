<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class DefrModuleBackupManagerCreateDumpsStream extends Migration
{

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug'         => 'dumps',
        'title_column' => 'title',
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'title',
        'path',
    ];

}
