<?php

namespace App\Entity;

use App\Application\Entity;
use DateTime;
use InvalidArgumentException;

/**
 * User.
 *
 * Entity class that represents a User
 */
final class User extends Entity
{
    /**
     * @var ?int
     */
    private ?int $id = null;

    /**
     * pseudo.
     *
     * @var string
     */
    private string $pseudo;

    /**
     * password.
     *
     * @var string
     */
    private string $password;
    
    /**
     * email
     *
     * @var string
     */
    private string $email;

    /**
     * dateCreation.
     *
     * @var DateTime
     */
    private DateTime $dateCreation;

    /**
     * activationKey.
     *
     * @var string
     */
    private string $activationKey;

    /**
     * enabled.
     *
     * @var int
     */
    private int $enabled = 1;

    /**
     * role.
     *
     * @var string
     */
    private string $role;

    public function isEnabled(): bool
    {
        if (2 === $this->getEnabled()) {
            return true;
        }

        return false;
    }

    /**
     * Get the value of id.
     *
     * @return ?int
     */
    public function getId(): ?int
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
     * Get pseudo.
     *
     * @return string
     */
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * Set pseudo.
     *
     * @param string $pseudo pseudo
     *
     * @return self
     */
    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password password
     *
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get dateCreation.
     *
     * @return DateTime
     */
    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

    /**
     * Set dateCreation.
     *
     * @param DateTime $dateCreation dateCreation
     *
     * @return self
     */
    public function setDateCreation(DateTime $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get activationKey.
     *
     * @return string
     */
    public function getActivationKey(): string
    {
        return $this->activationKey;
    }

    /**
     * Set activationKey.
     *
     * @param string $activationKey activationKey
     *
     * @return self
     */
    public function setActivationKey(string $activationKey): self
    {
        $this->activationKey = $activationKey;

        return $this;
    }

    /**
     * Get enabled.
     *
     * @return int
     */
    public function getEnabled(): int
    {
        return $this->enabled;
    }

    /**
     * Set enabled.
     *
     * @param int $enabled enabled
     *
     * @return self
     */
    public function setEnabled(int $enabled): self
    {
        if (in_array($enabled, [1, 2], true)) {
            $this->enabled = $enabled;

            return $this;
        }

        throw new InvalidArgumentException('User $enabled property must be equal to 1 or 2.');
    }

    /**
     * Get role.
     *
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * Set role.
     *
     * @param string $role role
     *
     * @return self
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get email
     *
     * @return  string
     */ 
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param  string  $email  email
     *
     * @return  self
     */ 
    public function setEmail(string $email): self
    {
        $email = filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
        if (empty($email)) {
            throw new InvalidArgumentException('invalid email');
        }
        $this->email = $email;

        return $this;
    }
}
