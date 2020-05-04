<?php
namespace App\Application;

abstract class Entity
{  
  /**
   * errors
   *
   * @var array
   */
  protected $errors = [];
  
  /**
   * id
   *
   * @var int
   */
  protected $id;

  public function __construct(array $data = [])
  {
    if (!empty($data))
    {
      $this->hydrate($data);
    }
  }

  public function hydrate(array $data) : void
  {
    foreach ($data as $key => $value)
    {
      $method = 'set'.ucfirst($key);

      if (is_callable([$this, $method]))
      {
        $this->$method($value);
      }
    }
  }

  /**
   * Method to find out if the entity is new.
   * @return bool
   */
  public function isNew() : bool
  {
    return empty($this->id);
  }

  /**
   * Method to find out if the entity is valid.
   * @return bool
   */
  abstract public function isValid();

  
  // GETTERS //
  public function getErrors() : array
  {
    return $this->errors;
  }

  public function getId() : int
  {
    return $this->id;
  }

  // SETTER //

  public function setId(int $id) : void
  {
    $this->id = (int) $id;
  }
}