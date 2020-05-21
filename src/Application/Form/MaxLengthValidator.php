<?php

namespace App\Application\Form;

use InvalidArgumentException;

/**
 * MaxLengthValidator.
 *
 * Validator to valid  maximum lentgh of field value
 */
class MaxLengthValidator extends Validator
{
    private int $maxLength;

    public function __construct(string $errorMessage, int $maxLength)
    {
        parent::__construct($errorMessage);
        $this->setMaxLength($maxLength);
    }

    public function isValid(?string $value): bool
    {
        if (null === $value) {
            return false;
        }

        return strlen($value) <= $this->maxLength;
    }

    /**
     * Set the value of maxLength.
     *
     * @return self
     */
    public function setMaxLength(int $maxLength): self
    {
        if ($maxLength > 0) {
            $this->maxLength = $maxLength;

            return $this;
        }

        throw new InvalidArgumentException('$maxLentgth property must be an interger not null');
    }
}
