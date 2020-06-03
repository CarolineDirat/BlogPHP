<?php

namespace App\Entity;

use App\Application\Entity;
use DateTime;

final class Post extends Entity
{
    /**
     * id.
     *
     * @var ?int
     */
    private ?int $id = null;

    /**
     * @var ?string
     */
    private ?string $title = null;

    private string $slug;

    /**
     * @var ?string
     */
    private ?string $content = null;

    /**
     * @var ?string
     */
    private ?string $abstract = null;

    private Datetime $dateCreation;

    private Datetime $dateUpdate;

    private int $idUser;

    /**
     * author.
     *
     * User's pseudo wich wrote the post
     *
     * @var ?string
     */
    private ?string $author = null;

    public function setId(int $id): self
    {
        $this->id = (int) $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setAbstract(string $abstract): self
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getAbstract(): ?string
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

    /**
     * Get user's pseudo wich wrote the post.
     *
     * @return string
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * Set user's pseudo wich wrote the post.
     *
     * @param string $author User's pseudo wich wrote the post
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }
}
