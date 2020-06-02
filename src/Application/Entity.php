<?php

namespace App\Application;

use Exception;

abstract class Entity
{
    use Hydrator;

    /**
     * errors.
     *
     * @var array[string]
     */
    protected $errors = [];

    /**
     * properties.
     *
     * array of entity's properties
     *
     * @var array
     */
    protected $properties = [];

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
        foreach (array_keys($data) as $property) {
            $method = 'get'.ucfirst($property);
            if (method_exists($this, $method)) {
                $this->properties[] = $property;
            }
        }
    }

    /**
     * isValid.
     *
     * checks if all entity propertoes are'nt not null
     */
    public function isValid(): bool
    {
        foreach ($this->getProperties() as $property) {
            $method = 'get'.ucfirst($property);
            if (!method_exists($this, $method)) {
                throw new Exception('The '.$method.' method is not callable');
            }
            if (empty($this->{$method}())) {
                return false;
            }
        }

        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function addError(string $error): self
    {
        $this->errors[] = $error;

        return $this;
    }

    /**
     * Get array of entity's properties.
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Set array of entity's properties.
     *
     * @param array $properties array of entity's properties
     */
    public function setProperties(array $properties): self
    {
        $this->properties = $properties;

        return $this;
    }
}
