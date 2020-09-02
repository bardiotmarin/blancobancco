<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 */
class Products
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $ProduitsTypes;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $Size;

    /**
     * @ORM\Column(type="string", length=300)
     */
    private $imgProducts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduitsTypes(): ?string
    {
        return $this->ProduitsTypes;
    }

    public function setProduitsTypes(string $ProduitsTypes): self
    {
        $this->ProduitsTypes = $ProduitsTypes;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->Size;
    }

    public function setSize(string $Size): self
    {
        $this->Size = $Size;

        return $this;
    }

    public function getImgProducts(): ?string
    {
        return $this->imgProducts;
    }

    public function setImgProducts(string $imgProducts): self
    {
        $this->imgProducts = $imgProducts;

        return $this;
    }
}
