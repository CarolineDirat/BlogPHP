<?php

namespace App\Application\Form;

use App\Application\HTTPRequest;

abstract class FormHandler
{
    protected Form $form;
    protected HTTPRequest $httpRequest;

    public function __construct(Form $form, HTTPRequest $httpRequest)
    {
        $this->setForm($form);
        $this->setHttpRequest($httpRequest);
    }

    /**
     * process.
     *
     * process a form
     */
    abstract public function process(): bool;

    /**
     * Set the value of form.
     */
    public function setForm(Form $form): self
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Set the value of httpRequest.
     */
    public function setHttpRequest(HTTPRequest $httpRequest): self
    {
        $this->httpRequest = $httpRequest;

        return $this;
    }
}
