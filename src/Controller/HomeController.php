<?php

namespace App\Controller;

use App\Application\AbstractController;
use App\Application\HTTPResponse;
use App\Application\PHPMailerApp;
use App\FormBuilder\ContactFormBuilder;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use App\Entity\Form\Contact;
use Exception;

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
        // Instantiate contact form
        $contact = new Contact();
        $formBuilder = new ContactFormBuilder($contact, $this->httpRequest);
        $formBuilder->build();
        $contactForm = $formBuilder->getForm();
        
        // Check for empty fields
        if (
            !$this->httpRequest->hasPost('captchaPhrase')
            || !$this->httpRequest->hasPost('firstName')
            || !$this->httpRequest->hasPost('lastName')
            || !$this->httpRequest->hasPost('email1')
            || !$this->httpRequest->hasPost('email2')
            || !$this->httpRequest->hasPost('messageContact')
        ) {
            // new captcha code
            $captcha = new CaptchaBuilder();
            $this->httpRequest->setSession('captchaPhrase', $captcha->getPhrase());

            return new HTTPResponse(
                'home',
                [
                    'captcha' => $captcha->build()->inline(), 
                    'contactForm' => $contactForm, 
                    'messageInfo' => "Le mail n'a pas pu être envoyé car il manque au moins un champs"
                ]
            );
        }

        // Check captcha
        // Checking that the posted phrase match the phrase stored in the session
        if (!PhraseBuilder::comparePhrases($this->httpRequest->getSession('captchaPhrase'), $this->httpRequest->postData('captchaPhrase'))) {
            // new captcha code
            $captcha = new CaptchaBuilder();
            $this->httpRequest->setSession('captchaPhrase', $captcha->getPhrase());
            
            return new HTTPResponse(
                'home',
                [
                    'contactForm' => $contactForm,
                    'captcha' => $captcha->build()->inline(),
                    'messageInfo' => "Le code recopié ne correspond pas à l'image"
                ]
            );
        }

        // Check emails equality
        if (
            !$this->httpRequest->postData('email1')
            || !$this->httpRequest->postData('email1')
            || $this->httpRequest->postData('email1') !== $this->httpRequest->postData('email2')
        ) {
            // new captcha code
            $captcha = new CaptchaBuilder();
            $this->httpRequest->setSession('captchaPhrase', $captcha->getPhrase());

            return new HTTPResponse(
                'home',
                [
                    'captcha' => $captcha->build()->inline(),
                    'contactForm' => $contactForm, 
                    'messageInfo' => "Le mail n'a pas pu être envoyé car au moins un des emails n'est pas valide."
                ]
            );
        }
        $mail = new PHPMailerApp(true);    // Instantiation of PHPMailer and passing `true` enables exceptions
        if (
            $mail->sendContact(
                EMAIL_CONTACT,
                $this->httpRequest->postData('firstName'),
                $this->httpRequest->postData('lastName'),
                $this->httpRequest->postData('email1'),
                $this->httpRequest->postData('messageContact')
            )
        ) {
            // new captcha code
            $captcha = new CaptchaBuilder();
            $this->httpRequest->setSession('captchaPhrase', $captcha->getPhrase());

            return new HTTPResponse(
                'home',
                [
                    'captcha' => $captcha->build()->inline(),
                    'contactForm' => $contactForm,
                    'messageInfo' => 'Votre message a bien été envoyé.'
                ]
            );
        }

        throw new Exception("L'envoie du mail a échoué :".$mail->ErrorInfo);
    }
}
