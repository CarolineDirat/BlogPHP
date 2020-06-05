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
     *
     * @var Form
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
     *
     * @return self
     */
    abstract public function build(): self;

    /**
     * Get form.
     *
     * @return Form
     */
    public function getForm(): Form
    {
        return $this->form;
    }

    /**
     * Set form.
     *
     * @param Form $form form
     *
     * @return self
     */
    public function setForm(Form $form): self
    {
        $this->form = $form;

        return $this;
    }
}
