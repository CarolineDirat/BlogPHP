<?php

namespace App\Model\Email;

//use App\Entity\Register;
use App\Entity\User;
use App\PHPMailer\AccountActivationPHPMailer;
use Exception;

/**
 * CommentEmailManager.
 */
class RegisterEmailManager
{
    /**
     * sendActivation.
     *
     * define params to send by sendMail() method of AccountActivationPHPMailer class to
     * send a mail to new user to invite him to activate his account
     *
     * @return bool
     */
    public function sendActivation(User $user): bool
    {
        $mail = new AccountActivationPHPMailer(true);    // Instantiation of PHPMailer and passing `true` enables exceptions
        // define $params for sendMail() method of AccountActivationPHPMailer class
        $params = [
            'recipient' => $user->getEmail(),
            'pseudo' => $user->getPseudo(),
            'key' => $user->getActivationKey(),
        ];
        // send the mail
        if ($mail->sendEmail($params)) {
            return true;
        }

        throw new Exception('Sending email to activate user account failed:'.$mail->ErrorInfo);
    }
}
