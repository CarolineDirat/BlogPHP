<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\Form\Form;
use App\Application\HTTPResponse;
use App\Entity\Form\Contact;
use App\FormBuilder\ContactFormBuilder;
use App\FormHandler\ContactFormHandler;
use App\Model\Email\ContactEmailManager;
use Gregwar\Captcha\CaptchaBuilder;

final class HomePublicController extends AbstractController
{
    /**
     * Controller to show the Home Page.
     */
    public function executeShowHome(): HTTPResponse
    {
        // process contact form if POST data
        if ('POST' === $this->httpRequest->method()) {
            // hydratation of Contact entity with POST data from contact form
            $contact = new Contact([
                'firstName' => $this->httpRequest->postData('firstName'),
                'lastName' => $this->httpRequest->postData('lastName'),
                'email1' => $this->httpRequest->postData('email1'),
                'email2' => $this->httpRequest->postData('email2'),
                'messageContact' => $this->httpRequest->postData('messageContact'),
                'captchaPhrase' => $this->httpRequest->postData('captchaPhrase'),
            ]);
            // Build contact form
            $contactForm = $this->buildContactForm($contact);
            // The process with checks
            $manager = new ContactEmailManager();
            $formHandler = new ContactFormHandler($contactForm, $manager, $this->httpRequest);
            if ($formHandler->process()) {
                // Build another empty contact form for the home page
                $contact = new Contact();
                $contactForm = $this->buildContactForm($contact);
                // new captcha code
                $captcha = $this->initCaptchaCode();

                return new HTTPResponse(
                    'home',
                    [
                        'captcha' => $captcha->build()->inline(),
                        'contactForm' => $contactForm,
                        'messageInfo' => 'Votre message a bien été envoyé.',
                        'user' => $this->httpRequest->getUserSession(),
                    ]
                );
            }
            // else, if process failed, display pre-filled contact form with warning messages
            $captcha = $this->initCaptchaCode(); // new captcha code

            return new HTTPResponse(
                'home',
                [
                    'captcha' => $captcha->build()->inline(),
                    'contactForm' => $contactForm,
                    'messageInfo' => "L'envoie du message a échoué, veuillez vérifier les champs du formulaire.",
                    'user' => $this->httpRequest->getUserSession(),
                ]
            );
        }
        // Else, if there is not POST data, display home page with empty contact form
        $captcha = $this->initCaptchaCode(); // new captcha code
        // Initialize empty contact form
        $contact = new Contact();
        $contactForm = $this->buildContactForm($contact);

        return new HTTPResponse(
            $this->getPage(),
            [
                'contactForm' => $contactForm,
                'captcha' => $captcha->build()->inline(),
                'user' => $this->httpRequest->getUserSession(),
            ]
        );
    }

    /**
     * initCaptchaCode.
     *
     * Initialization of catpcha code, and put it in $_SESSION['captchaPhrase']
     */
    public function initCaptchaCode(): CaptchaBuilder
    {
        // Creating the captcha instance and setting the phrase in the session to store
        // it for check when the form is submitted
        $captcha = new CaptchaBuilder();
        $this->httpRequest->setSession('captchaPhrase', $captcha->getPhrase());

        return $captcha;
    }

    /**
     * buildContactForm.
     *
     * create a contact form from Contact object
     */
    public function buildContactForm(Contact $contact): Form
    {
        $formBuilder = new ContactFormBuilder($contact, $this->httpRequest);

        return $formBuilder->build()->getForm();
    }
}
