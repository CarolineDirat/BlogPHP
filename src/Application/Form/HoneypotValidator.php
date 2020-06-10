<?php

namespace App\Application\Form;

/**
 * NotEmptyValidator.
 *
 * Validator to check if honeypot field has null value
 */
class HoneypotValidator extends Validator
{
    public function isValid(?string $value): bool
    {
        return empty($value);
    }
}
