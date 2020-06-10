<?php

namespace App\Application\Form;

use Exception;

/**
 * RegexValidator.
 *
 * Validator to know if field value is valid for a regex
 */
class RegexValidator extends Validator
{    
    /**
     * pattern
     *
     * @var string
     */
    private string $pattern;

    public function __construct(string $errorMessage, string $pattern)
    {
        parent::__construct($errorMessage);
        $this->setPattern($pattern);
    }
    
    public function isValid(?string $value): bool
    {
        switch (preg_match($this->getPattern(), $value)) {
            case 1:
                return true;
            case 0:
                return false;
            case false:
                throw new Exception("validation of password with preg_match() failed.");
            default:
                throw new Exception("validation of password with failed.");
        }
    }

    /**
     * Get pattern
     *
     * @return  string
     */ 
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * Set pattern
     *
     * @param  string  $pattern  pattern
     *
     * @return  self
     */ 
    public function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }
}
