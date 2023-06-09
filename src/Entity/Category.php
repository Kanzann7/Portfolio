<?php

namespace App\Entity;

class Category
{

    private int $idCategory;
    private string $name;


    public function __construct(array $data = [])
    {

        foreach ($data as $propertyName => $value) {
            $setter = 'set' . ucfirst($propertyName); // setIdCategory, setName
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }

    /**
     * Get the value of idCategory
     */
    public function getIdCategory(): int
    {
        return $this->idCategory;
    }

    /**
     * Set the value of idCategory
     */
    public function setIdCategory(int $idCategory): self
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
