<?php

namespace App\Entity;

use App\Application\Entity;
use DateTime;

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
     *
     * @var DateTime
     */
    private DateTime $dateCreation;

    /**
     * status.
     *
     * comment status witch can only be 'waiting', 'valid' or 'rejected'
     *
     * @var string
     */
    private string $status = 'waiting';

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
     * user's pseudo which wrote the comment
     *
     *  @var string
     */
    private string $author;

    /**
     * email.
     *
     * user's email which wrote the comment
     *
     * @var string
     */
    private string $email;

    /**
     * token.
     *
     * @var ?string
     */
    private ?string $token = null;

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
        $this->status = 'waiting';

        return $this;
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

    /**
     * Get user's email which wrote the comment.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set user's email which wrote the comment.
     *
     * @param string $email user's email which wrote the comment
     *
     * @return self
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get token.
     *
     * @return ?string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Set token.
     *
     * @param ?string $token token
     *
     * @return self
     */
    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
