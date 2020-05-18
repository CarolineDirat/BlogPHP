<?php

namespace App\Application\Form;

use InvalidArgumentException;

/**
 * InputTextField.
 *
 * Represent an intput field with type="text"
 */
class InputTextField extends Field
{
    const HTML_ELEMENT = 'input';
    const TYPE_ATTRIBUTE = 'text';

    /**
     * placeholder.
     *
     * @var ?string
     */
    private $placeholder;
    /**
     * required.
     *
     * @var ?string
     */
    private $required;
    /**
     * value.
     *
     * @var ?string
     */
    private $value;
    /**
     * maxlength.
     *
     * @var ?int
     */
    private $maxlength;

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
     * @return ?string
     */
    public function getRequired(): ?string
    {
        return $this->required;
    }

    /**
     * Set required.
     *
     * @param ?string $required required
     *
     * @return self
     */
    public function setRequired(?string $required): self
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
     * @param ?string $value value
     *
     * @return self
     */
    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
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
     * @param ?int $maxlength maxlength
     *
     * @return self
     */
    public function setMaxlength(?int $maxlength): self
    {
        if ($maxlength > 0) {
            $this->maxlength = $maxlength;

            return $this;
        }
        throw new InvalidArgumentException('$maxlength property must be an integer greater than 0');
    }
}
