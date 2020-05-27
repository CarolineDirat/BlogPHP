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
    private int $id;

    /**
     * content.
     *
     * @var string
     */
    private ?string $content = null;

    /**
     * dateCreation.
     *
     * @var DateTime
     */
    private DateTime $dateCreation;

    /**
     * permit.
     *
     * comment permit witch can only be 'waiting', 'valid' or 'rejected'
     *
     * @var string
     */
    private string $permit = 'waiting';

    /**
     * idPost.
     *
     * @var int
     */
    private int $idPost;

    /**
     * idUser.
     *
     * @var int
     */
    private int $idUser;

    /**
     * author.
     *
     * @var string
     */
    private string $author;

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
     *
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

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
     * Get permit.
     *
     * @return string
     */
    public function getPermit(): string
    {
        return $this->permit;
    }

    /**
     * Set permit.
     *
     * @param string $permit permit
     *
     * @return self
     */
    public function setPermit(string $permit): self
    {
        if (in_array($permit, ['waiting', 'valid', 'rejected'], true)) {
            $this->permit = $permit;

            return $this;
        }

        throw new InvalidArgumentException("Comment's permit can have only three values : 'waiting', 'rejected' or 'valid'");
    }

    /**
     * Get idPost.
     *
     * @return int
     */
    public function getIdPost(): int
    {
        return $this->idPost;
    }

    /**
     * Set idPost.
     *
     * @param int $idPost idPost
     *
     * @return self
     */
    public function setIdPost(int $idPost): self
    {
        $this->idPost = $idPost;

        return $this;
    }

    /**
     * Get idUser.
     *
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * Set idUser.
     *
     * @param int $idUser idUser
     *
     * @return self
     */
    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get author.
     *
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Set author.
     *
     * @param string $author author
     *
     * @return self
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }
}
