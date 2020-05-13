<?php

namespace App\Entity;

use DateTime;
use App\Application\Entity;

final class Post extends Entity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $slug;
    /**
     * @var string
     */
    private $content;
    /**
     * @var string
     */
    private $abstract;
    /**
     * @var Datetime
     */
    private $dateCreation;
    /**
     * @var Datetime
     */
    private $dateUpdate;
    /**
     * @var int
     */
    private $idUser;

    /**
     * Method to know if the post is valid.
     *
     * @return bool
     */
    public function isValid()
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

    public function getDateCreationString(): string
    {
        return $this->dateCreation;
    }

    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

    public function setDateUpdate(DateTime $dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    public function getDateUpdateString(): string
    {
        return $this->dateUpdate;
    }

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
