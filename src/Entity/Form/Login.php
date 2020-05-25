<?php

namespace App\Entity\Form;

use App\Application\Entity;

/**
 * User.
 *
 * Entity class that represents a User
 */
final class Login extends Entity
{
    /**
     * username.
     *
     * property to manage honeypot field
     *
     * @var ?string
     */
    private ?string $username = null;

    /**
     * pseudo.
     *
     * @var ?string
     */
    private ?string $pseudo = null;

    /**
     * password.
     *
     * @var ?string
     */
    private ?string $password = null;

    /**
     * Get property to manage honeypot field.
     *
     * @return ?string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set property to manage honeypot field.
     *
     * @param string $username property to manage honeypot field
     *
     * @return self
     */
    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get pseudo.
     *
     * @return ?string
     */
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    /**
     * Set pseudo.
     *
     * @param ?string $pseudo pseudo
     *
     * @return self
     */
    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get password.
     *
     * @return ?string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param ?string $password password
     *
     * @return self
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
