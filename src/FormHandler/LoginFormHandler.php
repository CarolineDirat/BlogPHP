<?php

namespace App\FormHandler;

use App\Application\Form\Form;
use App\Application\Form\FormHandler;
use App\Application\HTTPRequest;
use App\Entity\Form\Login;
use App\Model\UserManagerPDO;

class LoginFormHandler extends FormHandler
{
    private UserManagerPDO $userManagerPDO;

    public function __construct(Form $form, UserManagerPDO $userManagerPDO, HTTPRequest $httpRequest)
    {
        parent::__construct($form, $httpRequest);
        $this->setUserManagerPDO($userManagerPDO);
    }

    public function process(): bool
    {
        $login = $this->form->getEntity();
        // if checks ok ...
        if ($login instanceof Login && $this->form->isValid() && $this->userManagerPDO->hasLogin($login)) {
            // ... get $user and keep it in $_SESSION['user]
            $this->httpRequest
                ->setUserSession($this->userManagerPDO->getUser($login->getPseudo()))
            ;

            return true;
        }

        return false;
    }

    /**
     * Set the value of manager.
     */
    public function setUserManagerPDO(UserManagerPDO $userManagerPDO): self
    {
        $this->userManagerPDO = $userManagerPDO;

        return $this;
    }
}
