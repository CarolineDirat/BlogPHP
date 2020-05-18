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
     * textLabel.
     *
     * text in label tag
     *
     * @var string
     */
    protected $textLabel;

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
     * valueField.
     *
     * value of the field
     *
     * @var string
     */
    protected $valueField;

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

    public function isValid(): bool
    {
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($this->valueField)) {
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
     * Get textLabel.
     */
    public function getTextLabel(): string
    {
        return $this->textLabel;
    }

    /**
     * Set textLabel.
     *
     * @return self
     */
    public function setTextLabel(string $textLabel): self
    {
        $this->textLabel = $textLabel;

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
     * Get valueField.
     */
    public function getValueField(): string
    {
        return $this->valueField;
    }

    /**
     * Set valueField.
     *
     * @return self
     */
    public function setValueField(string $valueField): self
    {
        $this->valueField = $valueField;

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