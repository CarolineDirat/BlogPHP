<?php

namespace App\Application;

abstract class Entity
{
    use Hydrator;

    /**
     * errors.
     *
     * @var array[string]
     */
    protected $errors = [];

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    /**
     * isNew.
     *
     * Method to find out if the entity is new.
     */
    public function isNew(): bool
    {
        return empty($this->id);
    }

    /**
     * isValid.
     *
     * Method to find out if the entity is valid.
     */
    abstract public function isValid(): bool;

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function addError(string $error): self
    {
        $this->errors[] = $error;

        return $this;
    }
}
