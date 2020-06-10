<?php

namespace App\Application\Form;

/**
 * UniqueValidator.
 *
 * Validator which compare the field value with another value
 */
class UniqueValidator extends Validator
{
    /**
     * array.
     *
     * Array of values that must be different from the value of the field
     *
     * @var string[]
     */
    private array $array;

    public function __construct(string $errorMessage, array $array)
    {
        parent::__construct($errorMessage);
        $this->setArray($array);
    }

    public function isValid(?string $value): bool
    {
        return !in_array($value, $this->getArray(), true);
    }

    /**
     * Get array of values that must be different from the value of the field
     *
     * @return  string[]
     */ 
    public function getArray(): array
    {
        return $this->array;
    }

    /**
     * Set array of values that must be different from the value of the field
     *
     * @param  string[]  $array  Array of values that must be different from the value of the field
     *
     * @return  self
     */ 
    public function setArray(array $array): self
    {
        $this->array = $array;

        return $this;
    }
}
