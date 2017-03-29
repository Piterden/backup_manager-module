<?php namespace Defr\BackupManagerModule\Dump\Form;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Defr\BackupManagerModule\Dump\Command\WriteDump;

class DumpFormBuilder extends FormBuilder
{

    /**
     * The form fields.
     *
     * @var array|string
     */
    protected $fields = [
        'title',
        'path' => [
            'disabled' => true,
        ],
    ];

    /**
     * Fields to skip.
     *
     * @var array|string
     */
    protected $skips = [];

    /**
     * The form actions.
     *
     * @var array|string
     */
    protected $actions = [];

    /**
     * The form buttons.
     *
     * @var array|string
     */
    protected $buttons = [];

    /**
     * The form options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The form sections.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * The form assets.
     *
     * @var array
     */
    protected $assets = [];

    public function onPost()
    {
        if ($path = $this->dispatch(new WriteDump()))
        {
            $this->getFormEntry()->setPath($path);
        }
    }

}
