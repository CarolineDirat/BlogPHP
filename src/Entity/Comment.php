<?php

namespace App\Entity;

use App\Application\Entity;
use DateTime;
use InvalidArgumentException;

/**
 * Comment.
 *
 * Entity class that represents a comment
 */
final class Comment extends Entity
{
    /**
     * @var int
     */
    private ?int $id = null;

    /**
     * content.
     *
     * @var string
     */
    private ?string $content = null;

    /**
     * dateCreation.
     */
    private DateTime $dateCreation;

    /**
     * status.
     *
     * comment status witch can only be 'waiting', 'valid' or 'rejected'
     */
    private string $status = 'waiting';

    /**
     * idPost.
     */
    private int $idPost;

    /**
     * idUser.
     */
    private int $idUser;

    /**
     * author.
     */
    private string $author;

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
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get content.
     *
     * @return ?string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set content.
     *
     * @param string $content content
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get dateCreation.
     */
    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

    /**
     * Set dateCreation.
     *
     * @param DateTime $dateCreation dateCreation
     */
    public function setDateCreation(DateTime $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set status.
     *
     * @param string $status status
     *
     * @return self
     */
    public function setStatus(string $status): self
    {
        if (in_array($status, ['waiting', 'valid', 'rejected'], true)) {
            $this->status = $status;

            return $this;
        }

        throw new InvalidArgumentException("Comment's status can have only three values : 'waiting', 'rejected' or 'valid'");
    }

    /**
     * Get idPost.
     */
    public function getIdPost(): int
    {
        return $this->idPost;
    }

    /**
     * Set idPost.
     *
     * @param int $idPost idPost
     */
    public function setIdPost(int $idPost): self
    {
        $this->idPost = $idPost;

        return $this;
    }

    /**
     * Get idUser.
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * Set idUser.
     *
     * @param int $idUser idUser
     */
    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get author.
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Set author.
     *
     * @param string $author author
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }
}
