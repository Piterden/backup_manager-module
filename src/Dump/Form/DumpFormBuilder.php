<?php namespace Defr\BackupManagerModule\Dump\Form;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Defr\BackupManagerModule\Dump\Command\MakeDump;

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
     * The form buttons.
     *
     * @var array|string
     */
    protected $buttons = [];

    /**
     * The form sections.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * Do on post of form
     */
    public function onPost()
    {
        $entry = $this->getFormEntry();

        if (!$entry->getPath())
        {
            if ($path = $this->dispatch(new MakeDump()))
            {
                $entry->setPath($path);
            }
        }

        $entry->save();
    }

}
