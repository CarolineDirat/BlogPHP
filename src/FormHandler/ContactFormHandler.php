<?php

namespace App\FormHandler;

use App\Application\Form\Form;
use App\Application\Form\FormHandler;
use App\Application\HTTPRequest;
use App\Entity\Form\Contact;
use App\Model\Email\ContactEmailManager;

class ContactFormHandler extends FormHandler
{
    private ContactEmailManager $manager;

    public function __construct(Form $form, ContactEmailManager $manager, HTTPRequest $httpRequest)
    {
        parent::__construct($form, $httpRequest);
        $this->setManager($manager);
    }

    public function process(): bool
    {
        if ($this->form->isValid() && $this->form->getEntity() instanceof Contact) {
            return $this->manager->sendContact($this->form->getEntity());
        }

        return false;
    }

    /**
     * Set the value of $Mangaer.
     *
     * @return self
     */
    public function setManager(ContactEmailManager $manager): self
    {
        $this->manager = $manager;

        return $this;
    }
}
