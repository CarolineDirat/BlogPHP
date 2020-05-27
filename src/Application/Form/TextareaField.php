<?php

namespace App\Application\Form;

use InvalidArgumentException;

/**
 * TextareaField.
 *
 * Represent a textarea field
 */
class TextareaField extends Field
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
     * @var ?string
     */
    private ?string $required;

    /**
     * rows.
     *
     * @var ?int
     */
    private ?int $rows;

    /**
     * cols.
     *
     * @var ?int
     */
    private ?int $cols;
    
    /**
     * maxlength
     *
     * @var ?int
     */
    private ?int $maxlength;

    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->defineTextareaTag();
    }

    public function defineTextareaTag(): self
    {
        $this->tag = 'textarea';

        return $this;
    }

    /**
     * Get the value of placeholder.
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    /**
     * Set the value of placeholder.
     *
     * @return self
     */
    public function setPlaceholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get the value of required.
     */
    public function getRequired(): ?string
    {
        return $this->required;
    }

    /**
     * Set the value of required.
     *
     * @return self
     */
    public function setRequired(?string $required): self
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Get the value of rows.
     */
    public function getRows(): ?int
    {
        return $this->rows;
    }

    /**
     * Set the value of rows.
     *
     * @return self
     */
    public function setRows(int $rows): self
    {
        if ($rows > 0) {
            $this->rows = $rows;

            return $this;
        }

        throw new InvalidArgumentException('$rows property must be an integer greater than 0');
    }

    /**
     * Get the value of cols.
     */
    public function getCols(): ?int
    {
        return $this->cols;
    }

    /**
     * Set the value of cols.
     *
     * @return self
     */
    public function setCols(int $cols): self
    {
        if ($cols > 0) {
            $this->cols = $cols;

            return $this;
        }

        throw new InvalidArgumentException('$cols property must be an integer greater than 0');
    }

    /**
     * Get maxlength
     *
     * @return  ?int
     */ 
    public function getMaxlength(): ?int
    {
        return $this->maxlength;
    }

    /**
     * Set maxlength
     *
     * @param  ?int  $maxlength  maxlength
     *
     * @return  self
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
