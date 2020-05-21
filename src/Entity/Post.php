<?php

namespace App\Entity;

use App\Application\Entity;
use DateTime;

final class Post extends Entity
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $slug;

    /**
     * @var string
     */
    private string $content;

    /**
     * @var string
     */
    private string $abstract;

    /**
     * @var Datetime
     */
    private Datetime $dateCreation;

    /**
     * @var Datetime
     */
    private Datetime $dateUpdate;

    /**
     * @var int
     */
    private int $idUser;

    /**
     * Method to know if the post is valid.
     */
    public function isValid(): bool
    {
        return !(
            empty($this->title)
            || empty($this->slug)
            || empty($this->content)
            || empty($this->abstract)
            || empty($this->dateCreation)
            || empty($this->idUser)
        );
    }

    public function setId(int $id): self
    {
        $this->id = (int) $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setAbstract(string $abstract): self
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getAbstract(): string
    {
        return $this->abstract;
    }

    public function setDateCreation(DateTime $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * getDateCreation.
     *
     * @return DateTime
     */
    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

    public function setDateUpdate(DateTime $dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * getDateUpdate.
     *
     * @return DateTime
     */
    public function getDateUpdate(): DateTime
    {
        return $this->dateUpdate;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
    }
}
