<?php

namespace App\Application;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

abstract class PHPMailerApp extends PHPMailer
{
    public function __construct($exceptions = null)
    {
        parent::__construct($exceptions);

        // SETTINGS
        $this->set('CharSet', PHPMailer::CHARSET_UTF8);  // define the character set of the message at utf-8.
        // Server settings
        $this->SMTPDebug = 0;           // Enable verbose debug output with SMTP::DEBUG_SERVER, in develop environment (0 in production environment)
        $this->isSMTP();                                            // Send using SMTP
        $this->Host = SMTP_SERVER;                                  // Set the SMTP server to send through, defined in config.php
        $this->SMTPAuth = true;                                     // Enable SMTP authentication
        $this->Username = SMTP_USER;                                // SMTP username, defined in config.php
        $this->Password = SMTP_PASS;                                // SMTP password, defined in config.php
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $this->Port = 465;                                          // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        // Content
        $this->isHTML(true);   // Set email format to HTML
    }

    /**
     * sendEmail.
     *
     * Create a message (from the string data contained in the $param array)
     * and send it with $this->send() method
     *
     * @param string[] $params  ex: $recipient, data from a form, etc...
     *
     * @return bool             false on error - See the ErrorInfo property for details of the error
     */
    abstract public function sendEmail(array $params): bool;
}
