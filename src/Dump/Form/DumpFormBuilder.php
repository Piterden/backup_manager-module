<?php namespace Defr\BackupManagerModule\Dump\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Defr\BackupManagerModule\Dump\Command\MakeDump;
use Illuminate\Config\Repository;

class DumpFormBuilder extends FormBuilder
{

    /**
     * The form sections.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * Do on post form request
     */
    public function onPost()
    {
        // dd($this->getForm()->getFields());
        $fields = $this->getForm()->getFields()->filter(
            function (FieldType $field)
            {
                if ($field->getSlug() == 'database')
                {
                    return false;
                }

                if ($field->getSlug() == 'addon')
                {
                    return false;
                }

                return true;
            }
        );

        // dd($fields);

        $this->getForm()->getFields();

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
