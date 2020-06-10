<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\Form\Form;
use App\Application\HTTPResponse;
use App\Application\PDOSingleton;
use App\Entity\Form\Register;
use App\FormBuilder\RegisterFormBuilder;
use App\FormHandler\RegisterFormHandler;
use App\Model\UserManagerPDO;

/**
 * RegisterPublicController.
 *
 * Controller to manage a user registration
 */
final class RegisterPublicController extends AbstractController
{
    /**
     * executeShowRegister.
     *
     * Controller corresponding to the route /register
     *
     * @return HTTPResponse
     */
    public function executeShowRegister(): HTTPResponse
    {
        // Build empty registration form
        $register = new Register();
        $formbuilder = new RegisterFormBuilder($register, [], []);
        $registerForm = $formbuilder->build()->getForm();
        // manage url tree
        $correctPath = '';
        if ('register/save' === $this->httpRequest->requestURI()) {
            $correctPath = '../';
        }

        return new HTTPResponse(
            $this->getPage(),
            [
                'registerForm' => $registerForm,
                'correctPath' => $correctPath,
            ]
        );
    }

    /**
     * executeSaveRegister.
     *
     * Controller corresponding to the route /register/save
     *
     * @return HTTPResponse
     */
    public function executeSaveRegister(): HTTPResponse
    {
        $httpRequest = $this->httpRequest;
        if ('POST' === $httpRequest->method()) {
            $register = new Register([
                'pseudo' => $httpRequest->postData('pseudo'),
                'email' => $httpRequest->postData('email'),
                'confirmEmail' => $httpRequest->postData('confirmEmail'),
                'password' => $httpRequest->postData('password'),
                'confirmPassword' => $httpRequest->postData('confirmPassword'),
            ]);
            // To build registration form with values, we must know pseudos and emails already existing
            $dao = PDOSingleton::getInstance()->getConnexion();
            $manager = new UserManagerPDO($dao);
            $pseudos = $manager->getPseudos();
            $emails = $manager->getEmails();
            // Build registration form
            $formbuilder = new RegisterFormBuilder($register, $pseudos, $emails);
            $registerForm = $formbuilder->build()->getForm();
            // Instanciate FormHandler for registration form
            $formHandler = new RegisterFormHandler($registerForm, $manager, $httpRequest);
            // process the form
            if ($formHandler->process()) {
                return new HTTPResponse(
                    $this->getPage(),
                    [
                        'messageInfo' => 'Votre inscription a réussi. Il reste à activer votre compte en cliquant sur lien dans l\'email que vous avez reçu.',
                    ]
                );
            }

            return new HTTPResponse(
                $this->getPage(),
                [
                    'registerForm' => $registerForm,
                    'messageInfo' => 'Au moins un des champs n\'a pas été validé, veuillez suivre les indications :',
                ]
            );
        }

        return $this->executeShowRegister();
    }
}