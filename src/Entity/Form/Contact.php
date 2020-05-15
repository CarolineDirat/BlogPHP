<?php

namespace App\Entity\Form;

use App\Application\Entity;

/**
 * Contact
 * 
 * Entity class representing the fields of the contact form of the home page
 * Each property represent a field's value
 */
final class Contact extends Entity
{
    private string $firstName;
    private string $lastName;
    private string $email1;
    private string $email2;
    private string $messageContact;
    private string $captchaPhrase;   

    /**
     * Get the value of firstName
     */ 
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */ 
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of email1
     */ 
    public function getEmail1(): string
    {
        return $this->email1;
    }

    /**
     * Set the value of email1
     *
     * @return  self
     */ 
    public function setEmail1(string $email1): self
    {
        $this->email1 = $email1;

        return $this;
    }

    /**
     * Get the value of email2
     */ 
    public function getEmail2(): string
    {
        return $this->email2;
    }

    /**
     * Set the value of email2
     *
     * @return  self
     */ 
    public function setEmail2(string $email2): self
    {
        $this->email2 = $email2;

        return $this;
    }

    /**
     * Get the value of messageContact
     */ 
    public function getMessageContact(): string
    {
        return $this->messageContact;
    }

    /**
     * Set the value of messageContact
     *
     * @return  self
     */ 
    public function setMessageContact(string $messageContact): self
    {
        $this->messageContact = $messageContact;

        return $this;
    }

    /**
     * Get the value of captchaPhrase
     */ 
    public function getCaptchaPhrase(): string
    {
        return $this->captchaPhrase;
    }

    /**
     * Set the value of captchaPhrase
     *
     * @return  self
     */ 
    public function setCaptchaPhrase(string $captchaPhrase): self
    {
        $this->captchaPhrase = $captchaPhrase;

        return $this;
    }
}
