<?php

namespace App\FormHandler;

use App\Application\Form\Form;
use App\Model\UserManagerPDO;
use App\Application\HTTPRequest;
use App\Application\Form\FormHandler;
use App\Entity\Form\Login;

class LoginFormHandler extends FormHandler
{
    private UserManagerPDO $userManagerPDO;

    public function __construct(Form $form, UserManagerPDO $userManagerPDO, HTTPRequest $httpRequest)
    {
        $this->setForm($form);
        $this->setUserManagerPDO($userManagerPDO);
        $this->setHttpRequest($httpRequest);
    }
    
    public function process(): bool
    {
        $login = $this->form->getEntity();
        // if checks ok ...
        if ($login instanceof Login && $this->form->isValid() && $this->userManagerPDO->hasLogin($login)) {
            // ... get $user and keep it in $_SESSION['user]
            $this->httpRequest
                ->setUserSession($this->userManagerPDO->getUser($login->getPseudo()));
            return true;
        }
        return false;
    }

    /**
     * Set the value of manager
     *
     * @return  self
     */ 
    public function setUserManagerPDO(UserManagerPDO $userManagerPDO): self
    {
        $this->userManagerPDO = $userManagerPDO;

        return $this;
    }
}
