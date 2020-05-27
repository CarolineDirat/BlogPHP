<?php

namespace App\FormHandler;

use App\Application\Form\Form;
use App\Application\Form\FormHandler;
use App\Application\HTTPRequest;
use App\Entity\Form\Contact;
use App\Model\Email\ContactEmailManager;

class ContactFormHandler extends FormHandler
{
    private ContactEmailManager $emailManager;

    public function __construct(Form $form, ContactEmailManager $manager, HTTPRequest $httpRequest)
    {
        $this->setForm($form);
        $this->setEmailManager($manager);
        $this->setHttpRequest($httpRequest);
    }

    public function process(): bool
    {
        if ($this->form->isValid()) {
            if ($this->form->getEntity() instanceof Contact) {
                return $this->emailManager->sendContact($this->form->getEntity());
            }
        }

        return false;
    }

    /**
     * Set the value of $emailManager.
     *
     * @return self
     */
    public function setEmailManager(ContactEmailManager $emailManager)
    {
        $this->emailManager = $emailManager;

        return $this;
    }
}
