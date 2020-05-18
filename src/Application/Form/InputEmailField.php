<?php

namespace App\Application\Form;

use InvalidArgumentException;

/**
 * InputEmailField.
 *
 * Represent an intput field with type="email"
 */
class InputEmailField extends Field
{
    const HTML_ELEMENT = 'input';
    const TYPE_ATTRIBUTE = 'email';

    private bool $required;    
    /**
     * pattern
     *
     * @var ?string
     */

    private ?string $pattern;    
    /**
     * size
     *
     * @var ?int
     */
    private ?int $size;
    
    /**
     * maxlength
     *
     * @var ?int
     */
    private ?int $maxlength;
    
    /**
     * minlength
     *
     * @var ?int
     */
    private ?int $minlength;

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
     * Get pattern
     *
     * @return  ?string
     */ 
    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    /**
     * Set pattern
     *
     * @param  string  $pattern  pattern
     *
     * @return  self
     */ 
    public function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * Get size
     *
     * @return  ?int
     */ 
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * Set size
     *
     * @param  int  $size  size
     *
     * @return  self
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
        
        throw new InvalidArgumentException('$maxlength property must be an integer not null');
    }

    /**
     * Get minlength
     *
     * @return  ?int
     */ 
    public function getMinlength(): ?int
    {
        return $this->minlength;
    }

    /**
     * Set minlength
     *
     * @param  ?int  $minlength  minlength
     *
     * @return  self
     */ 
    public function setMinlength(?int $minlength): self
    {
        if ($minlength > 0) {
            $this->minlength = $minlength;

            return $this;
        }

        throw new InvalidArgumentException('$minlength property must be an integer not null');
    }
}