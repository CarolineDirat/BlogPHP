<?php

namespace App\Application\Form;

/**
 * InputField.
 *
 * field with html element = input
 */
class InputField extends Field
{
    /**
     * type.
     */
    protected string $type;

    /**
     * required.
     *
     * @var ?string
     */
    private ?string $required;

    /**
     * value.
     *
     * @var ?string
     */
    private ?string $value;

    /**
     * autofocus.
     *
     * @var ?string
     */
    private ?string $autofocus;

    /**
     * readonly.
     *
     * @var ?string
     */
    private $readonly;

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
     * Get type.
     */
    public function getType(): string
    {
        return $this->type;
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
     */
    public function setValue(?string $value): self
    {
        $this->value = filter_var($value, FILTER_SANITIZE_STRING);

        return $this;
    }

    /**
     * Get autofocus.
     *
     * @return ?string
     */
    public function getAutofocus(): ?string
    {
        return $this->autofocus;
    }

    /**
     * Set autofocus.
     *
     * @param ?string $autofocus autofocus
     */
    public function setAutofocus(?string $autofocus): self
    {
        $this->autofocus = $autofocus;

        return $this;
    }

    /**
     * Get readonly.
     *
     * @return ?string
     */
    public function getReadonly(): ?string
    {
        return $this->readonly;
    }

    /**
     * Set readonly.
     *
     * @param ?string $readonly readonly
     */
    public function setReadonly(?string $readonly): self
    {
        $this->readonly = $readonly;

        return $this;
    }
}
