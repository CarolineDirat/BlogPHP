<?php

namespace App\Application\Form;

/**
 * ValuesEqualityValidator
 * 
 * Validator which compare the field value with another value
 */
class ValuesEqualityValidator extends Validator
{    
    /**
     * refValue
     * 
     * the value which the field value must be compared
     *
     * @var string
     */
    private string $refValue;

    public function __construct(string $errorMessage, string $refValue)
    {
        parent::__construct($errorMessage);
        $this->setRefValue($refValue);
    }

    public function isValid(?string $value): bool
    {
        return $value === $this->refValue;
    }

    /**
     * Set the value of refValue
     *
     * @return  self
     */ 
    public function setRefValue(string $refValue): self
    {
        $this->refValue = $refValue;

        return $this;
    }
}
