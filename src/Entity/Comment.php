<?php

namespace App\Entity;

use DateTimeImmutable;

class Comment
{
    private int $id;
    private DateTimeImmutable $createdAt;
    private string $content;
    private User $user;
    private string $portfolioId;

    public function __construct(array $data = [])
    {
        foreach ($data as $propertyName => $value) {
            $setter = 'set' . ucfirst($propertyName);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }



    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of createdAt
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     */
    public function setCreatedAt(string|DateTimeImmutable $createdAt): self
    {
        if (is_string($createdAt)) {
            $createdAt = new DateTimeImmutable($createdAt);
        }
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of content
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }


    /**
     * Get the value of usersId
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Set the value of usersId
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of portfolioId
     */
    public function getPortfolioId(): string
    {
        return $this->portfolioId;
    }

    /**
     * Set the value of portfolioId
     */
    public function setPortfolioId(string $portfolioId): self
    {
        $this->portfolioId = $portfolioId;

        return $this;
    }

    public function getFormattedCreatedAt(): string
    {
        return $this->createdAt->format('d/m/Y') . ' à ' . $this->createdAt->format('H:i');
    }
}
