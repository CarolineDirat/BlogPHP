<?php

namespace App\Application\Form;

use InvalidArgumentException;

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

    /**
     * required.
     *
     * @var bool
     */
    private bool $required;

    /**
     * value.
     *
     * @var ?string
     */
    private ?string $value;

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

    /**
     * Get required.
     *
     * @return bool
     */
    public function getRequired(): bool
    {
        return $this->required;
    }

    /**
     * Set required.
     *
     * @param bool $required required
     *
     * @return self
     */
    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Get value.
     *
     * @return ?string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Set value.
     *
     * @param string $value value
     *
     * @return self
     */
    public function setValue(string $value): self
    {
        $value = filter_var($value, FILTER_SANITIZE_STRING);
        if ($value) {
            $this->value = $value;

            return $this;
        }

        throw new InvalidArgumentException('$value property must be a string not null');
    }
}
