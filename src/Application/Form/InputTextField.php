<?php

namespace App\Application\Form;

use InvalidArgumentException;

/**
 * InputTextField.
 *
 * Represent an intput field with type="text"
 */
class InputTextField extends InputField
{
    /**
     * placeholder.
     *
     * @var ?string
     */
    private ?string $placeholder;

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
    
    /**
     * maxlength.
     *
     * @var ?int
     */
    private ?int $maxlength;

    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->defineTextType();
    }

    public function defineTextType(): self
    {
        $this->type = 'text';

        return $this;
    }

    /**
     * Get placeholder.
     *
     * @return ?string
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    /**
     * Set placeholder.
     *
     * @param ?string $placeholder placeholder
     *
     * @return self
     */
    public function setPlaceholder(?string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
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

    /**
     * Get maxlength.
     *
     * @return ?int
     */
    public function getMaxlength(): ?int
    {
        return $this->maxlength;
    }

    /**
     * Set maxlength.
     *
     * @param int $maxlength maxlength
     *
     * @return self
     */
    public function setMaxlength(int $maxlength): self
    {
        if ($maxlength > 0) {
            $this->maxlength = $maxlength;

            return $this;
        }
        throw new InvalidArgumentException('$maxlength property must be an integer greater than 0');
    }
}
