<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\Form\Form;
use App\Application\HTTPResponse;
//use App\Application\HTTPRequest;
use App\Application\PDOSingleton;
use App\Entity\Form\Register;
use App\FormBuilder\RegisterFormBuilder;
//use App\FormHandler\RegisterFormHandler;
use App\Model\UserManagerPDO;

/**
 * RegisterPublicController
 * 
 * Controller to manage a user registration
 */
final class RegisterPublicController extends AbstractController
{    
    /**
     * executeShowRegister
     * 
     * Controller corresponding to the route /register
     *
     * @return HTTPResponse
     */
    public function executeShowRegister(): HTTPResponse
    {
        // We must know pseudos and emails already existing
        $dao = PDOSingleton::getInstance()->getConnexion();
        $manager = new UserManagerPDO($dao);
        $pseudos = $manager->getPseudos();
        $emails = $manager->getEmails();
        // Build empty registration form
        $register = new Register();
        $formbuilder = new RegisterFormBuilder($register, $pseudos, $emails);
        $registerForm = $formbuilder->build()->getForm();       

        return new HTTPResponse($this->getPage(), ['registerForm' => $registerForm]);
    }
    
    /**
     * executeSaveRegister
     * 
     * Controller corresponding to the route /register/save
     *
     * @return HTTPResponse
     
    *public function executeSaveRegister(): HTTPResponse
    *{
    *    $httpRequest = $this->httpRequest;
    *    if ('POST' === $httpRequest->method()) {
    *       $register = new Register([
    *          'pseudo' 
    *     ]);
    *    }
    *
    *    return new HTTPResponse(
    *        $this->getPage(), 
    *        [
    *            'registerForm' => $registerForm,
    *        ]
    *    );
    *}
    */
}
