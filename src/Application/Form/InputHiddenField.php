<?php

namespace App\Application\Form;

/**
 * InputHiddenField.
 * Represent an intput field with type="hidden".
 * 
 * Its name property can be equal to _charset_, 
 * and in this case, the value of the field sent with the form 
 * will be the encoding used for sending the form.
 */
class InputHiddenField extends InputField
{
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->type = 'hidden';
    }
}
