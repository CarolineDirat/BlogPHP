<?php

namespace App\Application\Form;

use App\Application\Entity;

/**
 * FormBuilder.
 *
 * Class witch inherit FormBuilders of each form
 */
abstract class FormBuilder
{
    /**
     * form.
     */
    protected Form $form;

    public function __construct(Entity $entity)
    {
        $this->setForm(new Form($entity));
    }

    /**
     * build.
     *
     * build form's fields
     */
    abstract public function build(): self;

    /**
     * getValueField.
     *
     * get a field value form its name
     *
     * @param  string $fieldName
     * @return string
     */
    public function getValueField(string $fieldName): string
    {
        $fields = $this->getForm()->getFields();
        $field = $fields[$fieldName];

        return ''.$field->getValueField();
    }

    /**
     * Get form.
     */
    public function getForm(): Form
    {
        return $this->form;
    }

    /**
     * Set form.
     *
     * @param Form $form form
     */
    public function setForm(Form $form): self
    {
        $this->form = $form;

        return $this;
    }
}
