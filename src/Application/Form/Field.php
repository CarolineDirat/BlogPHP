<?php

namespace App\Application\Form;

use App\Application\Hydrator;

/**
 * Field.
 *
 * A field of a form, which will be inherited by each type of field
 */
abstract class Field
{
    use Hydrator;

    /**
     * errorMessage.
     *
     * Error message when the field is not valid
     *
     * @var string
     */
    protected $errorMessage;

    /**
     * label.
     *
     * text in label tag
     *
     * @var string
     */
    protected $label;

    /**
     * name.
     *
     * value of the name attribute of the field
     *
     * @var string
     */
    protected $name;

    /**
     * idField.
     *
     * value of the id attribute of the field = value of for attribute of label tag
     *
     * @var string
     */
    protected $idField;

    /**
     * value.
     *
     * value of the field
     *
     * @var string
     */
    protected $value;

    /**
     * widget.
     *
     * HTML code to display the field in the template
     *
     * @var string
     */
    protected $widget;

    /**
     * validators.
     *
     * array of validators necessary to the field
     *
     * @var Validator[]
     */
    protected $validators = [];

    /**
     * __construct.
     *
     * @param array $options assign values to properties of the field
     */
    public function __construct(array $options = [])
    {
        if (!empty($options)) {
            $this->hydrate($options);
        }
    }

    abstract public function buildWidget(): string;

    public function isValid(): bool
    {
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($this->value)) {
                $this->errorMessage = $validator->getErrorMessage();

                return false;
            }
        }

        return true;
    }

    /**
     * Get errorMessage.
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * Set errorMessage.
     *
     * @return self
     */
    public function setErrorMessage(string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * Get label.
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set label.
     *
     * @return self
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get idField.
     */
    public function getIdField(): string
    {
        return $this->idField;
    }

    /**
     * Set idField.
     *
     * @return self
     */
    public function setIdField(string $idField): self
    {
        $this->idField = $idField;

        return $this;
    }

    /**
     * Get value.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Set value.
     *
     * @return self
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get widget.
     */
    public function getWidget(): string
    {
        return $this->widget;
    }

    /**
     * Set widget.
     *
     * @return self
     */
    public function setWidget(string $widget): self
    {
        $this->widget = $widget;

        return $this;
    }

    /**
     * Get validators.
     */
    public function getValidators(): array
    {
        return $this->validators;
    }

    /**
     * Set validators.
     *
     * @return self
     */
    public function setValidators(array $validators)
    {
        foreach ($validators as $validator) {
            if ($validator instanceof Validator && !in_array($validator, $this->validators)) {
                $this->validators[] = $validator;
            }
        }

        return $this;
    }
}
