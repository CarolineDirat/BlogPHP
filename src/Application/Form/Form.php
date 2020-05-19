<?php

namespace App\Application\Form;

use App\Application\Entity;

/**
 * Form.
 *
 * A form to be create from an Entity
 */
class Form
{
    /**
     * entity.
     *
     * Entity corresponding to the form to hydrate its fields
     *
     * @var Entity
     */
    private $entity;

    /**
     * fields.
     *
     * array of fields making up the form
     *
     * @var Field[]
     */
    private $fields = [];

    public function __construct(Entity $entity)
    {
        $this->setEntity($entity);
    }

    /**
     * isValid.
     *
     * checks validity of form's fields
     *
     * @return bool
     */
    public function isValid(): bool
    {
        $valid = true;
        foreach ($this->fields as $field) {
            if (!$field->isValid()) {
                $valid = false;
            }
        }

        return $valid;
    }

    /**
     * Get entity corresponding to the form to hydrate its fields.
     *
     * @return Entity
     */
    public function getEntity(): Entity
    {
        return $this->entity;
    }

    /**
     * Set entity corresponding to the form to hydrate its fields.
     *
     * @param Entity $entity Entity corresponding to the form to hydrate its fields
     *
     * @return self
     */
    public function setEntity(Entity $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get array of fields making up the form.
     *
     * @return Field[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Add a field to the list of fields.
     *
     * @param Field $field
     *
     * @return self
     */
    public function addField(Field $field): self
    {
        $property = 'get'.ucfirst($field->getName());
        $field->setValueField($this->entity->$property()); // assigns the value of the entity property to the value of the corresponding field
        $this->fields[] = $field;

        return $this;
    }
}
