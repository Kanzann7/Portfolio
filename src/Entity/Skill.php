<?php

namespace App\Entity;

class Skill
{

    private int $id;
    private ?string $image;
    private ?string $content;

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
     * Get the value of image
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Set the value of image
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of content
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
