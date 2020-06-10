<?php

namespace App\Application\Form;

use InvalidArgumentException;

/**
 * MinLengthValidator.
 *
 * Validator to valid a minimum lentgh of field value
 */
class MinLengthValidator extends Validator
{
    private int $minLength;

    public function __construct(string $errorMessage, int $minLength)
    {
        parent::__construct($errorMessage);
        $this->setMinLength($minLength);
    }

    public function isValid(?string $value): bool
    {
        if (null === $value) {
            return false;
        }

        return strlen($value) >= $this->minLength;
    }

    /**
     * Set the value of MinLength.
     *
     * @return self
     */
    public function setMinLength(int $minLength): self
    {
        if ($minLength > 0) {
            $this->minLength = $minLength;

            return $this;
        }

        throw new InvalidArgumentException('$minLentgth property must be an interger not null');
    }
}
