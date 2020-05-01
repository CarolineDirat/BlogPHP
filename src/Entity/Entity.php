<?php
namespace App\Application;

abstract class Entity
{
  protected $errors = [],
            $id;

  public function __construct(array $data = []) : void
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
   * Méthode permettant de savoir si la news est nouvelle.
   * @return bool
   */
  public function isNew() : bool
  {
    return empty($this->id);
  }

  /**
   * Méthode permettant de savoir si l'entité est valide.
   * @return bool
   */
  abstract public function isValid();

  public function errors() : array
  {
    return $this->errors;
  }

  public function getId() : int
  {
    return $this->id;
  }

  public function setId($id) : void
  {
    $this->id = (int) $id;
  }
}