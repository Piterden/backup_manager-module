<?php namespace Defr\BackupManagerModule\Dump\Form;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class DumpFormBuilder extends FormBuilder
{

    /**
     * The form skips
     *
     * @var        array
     */
    protected $skips = [
        'path',
    ];
}
