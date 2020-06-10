<?php

namespace App\Entity\Form;

use App\Application\Entity;

/**
 * Contact.
 *
 * Entity class representing the fields of the register form 
 * Each property represent a field's value
 */
final class Register extends Entity
{   
    /**
     * pseudo
     *
     * @var ?string
     */
    private ?string $pseudo  = null;

    /**
     * confirmPseudo
     * 
     * property for the honeypot field
     *
     * @var ?string
     */
    private ?string $confirmPseudo = null;
    
    /**
     * email
     *
     * @var ?string
     */
    private ?string $email = null;
    
    /**
     * confirmEmail
     *
     * @var ?string
     */
    private ?string $confirmEmail = null;
    
    /**
     * password
     *
     * @var ?string
     */
    private ?string $password = null;
    
    /**
     * confirmPassword
     *
     * @var ?string
     */
    private ?string $confirmPassword = null;

    /**
     * Get pseudo
     *
     * @return  ?string
     */ 
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    /**
     * Set pseudo
     *
     * @param  ?string  $pseudo  pseudo
     *
     * @return  self
     */ 
    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get property for the honeypot field
     *
     * @return  ?string
     */ 
    public function getConfirmPseudo(): ?string
    {
        return $this->confirmPseudo;
    }

    /**
     * Set property for the honeypot field
     *
     * @param  ?string  $confirmPseudo  property for the honeypot field
     *
     * @return  self
     */ 
    public function setConfirmPseudo(?string $confirmPseudo): self
    {
        $this->confirmPseudo = $confirmPseudo;

        return $this;
    }

    /**
     * Get email
     *
     * @return  ?string
     */ 
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param  ?string  $email  email
     *
     * @return  self
     */ 
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get confirmEmail
     *
     * @return  ?string
     */ 
    public function getConfirmEmail(): ?string
    {
        return $this->confirmEmail;
    }

    /**
     * Set confirmEmail
     *
     * @param  ?string  $confirmEmail  confirmEmail
     *
     * @return  self
     */ 
    public function setConfirmEmail(?string $confirmEmail): self
    {
        $this->confirmEmail = $confirmEmail;

        return $this;
    }

    /**
     * Get password
     *
     * @return  ?string
     */ 
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param  ?string  $password  password
     *
     * @return  self
     */ 
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get confirmPassword
     *
     * @return  ?string
     */ 
    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    /**
     * Set confirmPassword
     *
     * @param  ?string  $confirmPassword  confirmPassword
     *
     * @return  self
     */ 
    public function setConfirmPassword(?string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
