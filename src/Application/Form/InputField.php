<?php

namespace App\Application\Form;

/**
 * InputField
 * 
 * field with html element = input
 */
class InputField extends Field
{    
    /**
     * type
     *
     * @var string
     */
    protected string $type;

    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->defineInputTag();
    }

    public function defineInputTag(): self
    {
            $this->tag = 'input';

            return $this;
    }

    /**
     * Get type
     *
     * @return  string
     */ 
    public function getType(): string
    {
        return $this->type;
    }
}
