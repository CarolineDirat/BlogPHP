<?php

namespace App\Application\Form;

use InvalidArgumentException;

/**
 * NotEmptyValidator.
 *
 * Validator to know if field value is empty 
 */
class NotEmptyValidator extends Validator
{
    public function isValid(?string $value): bool
    {
        return !empty($value);
    }
}
