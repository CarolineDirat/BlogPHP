<?php

namespace App\Application\Form;

/**
 * NotEmptyValidator.
 *
 * Validator to know if field value is empty (or null)
 */
class NotEmptyValidator extends Validator
{
    public function isValid(?string $value): bool
    {
        return !empty($value);
    }
}
