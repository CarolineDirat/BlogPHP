<?php

namespace App\Entity;

use App\Application\Entity;
use DateTime;

/**
 * User.
 *
 * Entity class that represents a User
 */
final class User extends Entity
{
    /**
     * @var int
     */
    private int $id;
    
    /**
     * pseudo
     *
     * @var string
     */
    private $pseudo;
    
    /**
     * password
     *
     * @var string
     */
    private $password;
    
    /**
     * dateCreation
     *
     * @var DateTime
     */
    private $dateCreation;
    
    /**
     * activationKey
     *
     * @var string
     */
    private $activationKey;
    
    /**
     * enabled
     *
     * @var int
     */
    private $enabled = 0;

    public function isEnabled(): bool
    {
        if (1 === $this->getEnabled()) {
            return true;
        }
        return false;
    }

    /**
     * Get the value of id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id.
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return  string
     */ 
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * Set pseudo
     *
     * @param  string  $pseudo  pseudo
     *
     * @return  self
     */ 
    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get password
     *
     * @return  string
     */ 
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param  string  $password  password
     *
     * @return  self
     */ 
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return  DateTime
     */ 
    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

    /**
     * Set dateCreation
     *
     * @param  DateTime  $dateCreation  dateCreation
     *
     * @return  self
     */ 
    public function setDateCreation(DateTime $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get activationKey
     *
     * @return  string
     */ 
    public function getActivationKey(): string
    {
        return $this->activationKey;
    }

    /**
     * Set activationKey
     *
     * @param  string  $activationKey  activationKey
     *
     * @return  self
     */ 
    public function setActivationKey(string $activationKey): self
    {
        $this->activationKey = $activationKey;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return  int
     */ 
    public function getEnabled(): int
    {
        return $this->enabled;
    }

    /**
     * Set enabled
     *
     * @param  int  $enabled  enabled
     *
     * @return  self
     */ 
    public function setEnabled(int $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }
}