<?php

namespace App\Application\Form;

/**
 * Validator
 * 
 * Class wich will be inherit by the different field validators
 * A field can be associated with several types of validators.
 */
abstract class Validator
{
    protected string $errorMessage;
    
    public function __construct(string $errorMessage)
    {
        $this->setErrorMessage($errorMessage);
    }

    abstract public function isValid(string $value): bool;

    /**
     * Get the value of errorMessage
     */ 
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * Set the value of errorMessage
     *
     * @return  self
     */ 
    public function setErrorMessage($errorMessage): self
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }
}
