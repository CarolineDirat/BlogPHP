<?php

namespace App\Application\Form;

/**
 * NotEmptyValidator.
 *
 * Validator to check if the field is not empty
 */
class NotEmptyValidator extends Validator
{
    public function isValid(?string $value): bool
    {
        return !empty($value);
    }
}
