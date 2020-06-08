<?php

namespace App\PHPMailer;

use App\Application\PHPMailerApp;
use InvalidArgumentException;

/**
 * CommentReportAdminPHPMailer.
 *
 * Build and send the mail to report Admin of creation of a comment to validate
 * thanks to sendMail() method
 */
class CommentReportAdminPHPMailer extends PHPMailerApp
{
    /**
     * sendEmail.
     *
     * Create and send a email to report Admin of creation of a comment to validate
     * thanks to sendMail() method,
     *
     * the $params array must contains :
     *
     *  string $linkToLogin     Link to go to the login page of CaroCode website 
     *                          ex : '<a href='http://blogphp/login' >Se connecter</a>'
     *  string $title           Title of the post corresponding to the comment
     *  string $comment         Content of the comment
     *
     * @param string[] $params
     *
     * @return bool false on error - See the ErrorInfo property for details of the error
     */
    public function sendEmail(array $params): bool
    {
        // We check that the $params array has the right keys
        foreach (array_keys($params) as $value) {
            if (!in_array($value, ['linkToLogin', 'title', 'comment'], true)) {
                throw new InvalidArgumentException('The params data array passed to sendEmail(params) method is not valid.');
            }
        }
        // Recipients
        $this->setFrom('ne-pas-repondre@carocode.com', 'CaroCode');
        $this->addAddress(EMAIL_ADMIN,);   // Add a recipient (Name is optional)
        $this->Subject = 'Un nouveau commentaire à valider dans CaroCode : ';    // Here is the subject
        // This is the HTML message body <b>in bold!</b>:
        $this->Body = 'Nouveau commentaire sur le post <b>'.strtoupper($params['title']).'</b><br/>
        << '.$params['comment'].'>> <br/>
        '.$params['linkToLogin'].'<br/>';
        // This is the body in plain text for non-HTML mail clients:
        $this->AltBody = 'voici le commentaire à valider '.$params['comment'].', du post '.strtoupper($params['title']).': '.$params['linkToLogin'];

        return $this->send();
    }
}
