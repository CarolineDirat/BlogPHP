<?php

namespace App\Model\Form;

use Exception;
use App\Application\PHPMailerApp;
use App\Entity\Form\Contact;

/**
 * ContactManager
 * 
 * contains method called by ContactFormHandler to process the contact form
 */
class ContactManager
{
    public function sendEmail(Contact $contact): bool
    {
        $mail = new PHPMailerApp(true);    // Instantiation of PHPMailer and passing `true` enables exceptions
        if (
            $mail->sendContact(
                EMAIL_CONTACT,
                $contact->getFirstName(),
                $contact->getLastName(),
                $contact->getEmail1(),
                $contact->getMessageContact()
            )
        ) {
            return true;
        }

        throw new Exception("L'envoie du mail a échoué :" . $mail->ErrorInfo);
    }
}
