<?php

namespace App\FormHandler;

use App\Application\Form\Form;
use App\Application\Form\FormHandler;
use App\Application\HTTPRequest;
use App\Entity\Form\Register;
use App\Entity\User;
use App\Model\UserManagerPDO;

class RegisterFormHandler extends FormHandler
{
    private UserManagerPDO $manager;

    public function __construct(Form $form, UserManagerPDO $manager, HTTPRequest $httpRequest)
    {
        parent::__construct($form, $httpRequest);
        $this->setManager($manager);
    }

    /**
     * process.
     *
     * check form validity, then if it's ok, save the user in database
     *
     * @return bool
     */
    public function process(): bool
    {
        $register = $this->form->getEntity();
        if ($register instanceof Register && $this->form->isValid()) {
            $user = new User([
                'pseudo' => $register->getPseudo(),
                'email' => $register->getEmail(),
                'password' => $register->getPassword(),
                'role' => 'subscriber',
            ]);

            return $this->manager->save($user);
        }

        return false;
    }

    /**
     * Set the value of manager.
     *
     * @return self
     */
    public function setManager(UserManagerPDO $manager): self
    {
        $this->manager = $manager;

        return $this;
    }
}
