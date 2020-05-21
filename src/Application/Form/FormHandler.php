<?php

namespace App\Application\Form;

use App\Application\HTTPRequest;
use App\Application\Manager;

abstract class FormHandler
{
    protected Form $form;
    protected Manager $manager;
    protected HTTPRequest $httpRequest;

    public function __construct(Form $form, Manager $manager, HTTPRequest $httpRequest)
    {
        $this->setForm($form);
        $this->setManager($manager);
        $this->setHttpRequest($httpRequest);
    }

    // cette fonction est abstraite pour le moment, mais elle sera définie
    // par défaut pour faire appel à la méthode save() de PostManager, CommentManager et UserManager
    abstract public function process(): bool;

    /**
     * Set the value of form.
     *
     * @return self
     */
    public function setForm(Form $form): self
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Set the value of manager.
     *
     * @return self
     */
    public function setManager(Manager $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Set the value of httpRequest.
     *
     * @return self
     */
    public function setHttpRequest(HTTPRequest $httpRequest): self
    {
        $this->httpRequest = $httpRequest;

        return $this;
    }
}
