<?php

namespace App\Entity;

use App\Application\Entity;
use DateTime;

final class Post extends Entity
{
    /**
     * id
     *
     * @var ?int
     */
    private ?int $id = null;

    /**
     * title
     * 
     * @var ?string
     */
    private ?string $title = null;
    
    /**
     * slug
     *
     * @var string
     */
    private string $slug;

    /**
     * content
     * 
     * @var ?string
     */
    private ?string $content = null;

    /**
     * abstract
     * 
     * @var ?string
     */
    private ?string $abstract = null;
    
    /**
     * dateCreation
     *
     * @var DateTime
     */
    private DateTime $dateCreation;
    
    /**
     * dateUpdate
     *
     * @var DateTime
     */
    private DateTime $dateUpdate;
    
    /**
     * idUser
     *
     * @var int
     */
    private int $idUser;

    /**
     * author.
     *
     * User's pseudo wich wrote the post
     *
     * @var ?string
     */
    private ?string $author = null;
    
    /**
     * setId
     *
     * @param  int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = (int) $id;

        return $this;
    }
    
    /**
     * getId
     *
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * setTitle
     *
     * @param ?string $title
     * @return self
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
    
    /**
     * getTitle
     *
     * @return ?string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    
    /**
     * setSlug
     *
     * @param  string $slug
     * @return self
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
    
    /**
     * getSlug
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }
    
    /**
     * setContent
     *
     * @param  string $content
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
    
    /**
     * getContent
     *
     * @return ?string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
    
    /**
     * setAbstract
     *
     * @param  string $abstract
     * @return self
     */
    public function setAbstract(string $abstract): self
    {
        $this->abstract = $abstract;

        return $this;
    }
    
    /**
     * getAbstract
     *
     * @return ?string
     */
    public function getAbstract(): ?string
    {
        return $this->abstract;
    }
    
    /**
     * setDateCreation
     *
     * @param  DateTime $dateCreation
     * @return self
     */
    public function setDateCreation(DateTime $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

        
    /**
     * getDateCreation
     *
     * @return DateTime
     */
    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }
    
    /**
     * setDateUpdate
     *
     * @param  DateTime $dateUpdate
     * @return self
     */
    public function setDateUpdate(DateTime $dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

        
    /**
     * getDateUpdate
     *
     * @return DateTime
     */
    public function getDateUpdate(): DateTime
    {
        return $this->dateUpdate;
    }
    
    /**
     * setIdUser
     *
     * @param  int $idUser
     * @return self
     */
    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }
    
    /**
     * getIdUser
     *
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * Get user's pseudo wich wrote the post.
     *
     * @return ?string
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
