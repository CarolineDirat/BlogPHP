<?php

namespace App\Application\Form;

/**
 * InputTokenField.
 * Represent an intput field with type="hidden", for the token CSRF.
 */
class InputTokenField extends InputHiddenField
{
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->name = 'token';
    }
}
