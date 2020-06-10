<?php

namespace App\Application\Form;

use InvalidArgumentException;

/**
 * InputPasswordField.
 *
 * Represent an intput field with type="password"
 * with its own additional attributes to those of the input tag
 */
class InputPasswordField extends InputField
{
    /**
     * placeholder.
     *
     * @var ?string
     */
    private ?string $placeholder;

    /**
     * pattern.
     *
     * @var ?string
     */
    private ?string $pattern;

    /**
     * size.
     *
     * @var ?int
     */
    private ?int $size;

    /**
     * maxlength.
     *
     * @var ?int
     */
    private ?int $maxlength;

    /**
     * minlength.
     *
     * @var ?int
     */
    private ?int $minlength;
    
    /**
     * title
     *
     * @var ?string
     */
    private ?string $title;

    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->type = 'password';
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
     * Get pattern.
     *
     * @return ?string
     */
    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    /**
     * Set pattern.
     *
     * @param string $pattern pattern
     *
     * @return self
     */
    public function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * Get size.
     *
     * @return ?int
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * Set size.
     *
     * @param int $size size
     *
     * @return self
     */
    public function setSize(int $size): self
    {
        if ($size > 0) {
            $this->size = $size;

            return $this;
        }

        throw new InvalidArgumentException('$size property must be an integer not null');
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

        throw new InvalidArgumentException('$maxlength property must be an integer not null');
    }

    /**
     * Get minlength.
     *
     * @return ?int
     */
    public function getMinlength(): ?int
    {
        return $this->minlength;
    }

    /**
     * Set minlength.
     *
     * @param ?int $minlength minlength
     *
     * @return self
     */
    public function setMinlength(?int $minlength): self
    {
        if ($minlength > 0) {
            $this->minlength = $minlength;

            return $this;
        }

        throw new InvalidArgumentException('$minlength property must be an integer not null');
    }

    /**
     * Get title
     *
     * @return  ?string
     */ 
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param  ?string  $title  title
     *
     * @return  self
     */ 
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
