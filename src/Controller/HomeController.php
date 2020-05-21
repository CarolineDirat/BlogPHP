<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use App\Entity\Form\Contact;
use App\FormBuilder\ContactFormBuilder;
use App\FormHandler\ContactFormHandler;
use App\Model\Form\ContactManager;
use Gregwar\Captcha\CaptchaBuilder;

//use App\Application\TwigRenderer;

final class HomeController extends AbstractController
{
    /**
     * Controller to show the Home Page.
     */
    public function executeShowHome(): HTTPResponse
    {
        // Creating the captcha instance and setting the phrase in the session to store
        // it for check when the form is submitted
        $captcha = new CaptchaBuilder();
        $this->httpRequest->setSession('captchaPhrase', $captcha->getPhrase());

        // Instantiate contact form
        $contact = new Contact();
        $formBuilder = new ContactFormBuilder($contact, $this->httpRequest);
        $formBuilder->build();
        $contactForm = $formBuilder->getForm();

        // Retrieve the captcha to insert it directly into the home.twig page:
        return new HTTPResponse($this->getPage(), ['contactForm' => $contactForm, 'captcha' => $captcha->build()->inline()]);
    }

    /**
     * Controller to process the contact form.
     */
    public function executeProcessContact(): HTTPResponse
    {
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
        $formBuilder = new ContactFormBuilder($contact, $this->httpRequest);
        $formBuilder->build();
        $contactForm = $formBuilder->getForm();
        // The process with checks
        $manager = new ContactManager();
        $formHandler = new ContactFormHandler($contactForm, $manager, $this->httpRequest);
        if ($formHandler->process()) {
            // Build another empty contact form for the home page
            $contact = new Contact();
            $formBuilder = new ContactFormBuilder($contact, $this->httpRequest);
            $formBuilder->build();
            $contactForm = $formBuilder->getForm();
            // new captcha code
            $captcha = $this->initCaptchaCode();

            return new HTTPResponse(
                'home',
                [
                    'captcha' => $captcha->build()->inline(),
                    'contactForm' => $contactForm,
                    'messageInfo' => 'Votre message a bien été envoyé.',
                ]
            );
        }
        // new captcha code
        $captcha = $this->initCaptchaCode();

        return new HTTPResponse(
            'home',
            [
                'captcha' => $captcha->build()->inline(),
                'contactForm' => $contactForm,
                'messageInfo' => "L'envoie du message a échoué, veuillez vérifier les champs du formulaire.",
            ]
        );
    }

    /**
     * initCaptchaCode.
     *
     * Initialization of catpcha code, and put it in $_SESSION['captchaPhrase']
     *
     * @return CaptchaBuilder
     */
    public function initCaptchaCode(): CaptchaBuilder
    {
        $captcha = new CaptchaBuilder();
        $this->httpRequest->setSession('captchaPhrase', $captcha->getPhrase());

        return $captcha;
    }
}
