<?php

namespace App\Model\Email;

use App\Entity\Form\Contact;
use App\PHPMailer\ContactPHPMailer;
use Exception;

/**
 * ContactEmailManager.
 *
 * contains method called by ContactFormHandler to process the contact form
 */
class ContactEmailManager
{
    public function sendContact(Contact $contact): bool
    {
        $mail = new ContactPHPMailer(true);    // Instantiation of PHPMailer and passing `true` enables exceptions
        $params = [
            'recipient' => EMAIL_CONTACT,
            'firstName' => $contact->getFirstName(),
            'lastName' => $contact->getLastName(),
            'email' => $contact->getEmail1(),
            'messageContact' => $contact->getMessageContact(),
        ];
        if ($mail->sendEmail($params)) {
            return true;
        }

        throw new Exception('Sending email failed:'.$mail->ErrorInfo);
    }
}
