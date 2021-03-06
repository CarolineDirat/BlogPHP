<?php

namespace App\Application\Form;

use InvalidArgumentException;

/**
 * InputTextField.
 * Represent an intput field with type="text".
 * with its own additional attributes to those of the input tag.
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
     * maxlength.
     *
     * @var ?int
     */
    private ?int $maxlength;

    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->type = 'text';
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
