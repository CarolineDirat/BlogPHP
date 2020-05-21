<?php

namespace App\FormHandler;

use App\Application\Form\Form;
use App\Application\Form\FormHandler;
use App\Application\HTTPRequest;
use App\Entity\Form\Contact;
use App\Model\Form\ContactManager;

class ContactFormHandler extends FormHandler
{
    private ContactManager $contactManager;

    public function __construct(Form $form, ContactManager $contactManager, HTTPRequest $httpRequest)
    {
        $this->setForm($form);
        $this->setContactManager($contactManager);
        $this->setHttpRequest($httpRequest);
    }

    public function process(): bool
    {
        if ('POST' === $this->httpRequest->method() && $this->form->isValid()) {
            if ($this->form->getEntity() instanceof Contact) {
                return $this->contactManager->sendEmail($this->form->getEntity());
            }
        }

        return false;
    }

    /**
     * Set the value of contactManager.
     *
     * @return self
     */
    public function setContactManager(ContactManager $contactManager)
    {
        $this->contactManager = $contactManager;

        return $this;
    }
}
