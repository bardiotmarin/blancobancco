<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $NumeroCommande;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCommande(): ?int
    {
        return $this->NumeroCommande;
    }

    public function setNumeroCommande(int $NumeroCommande): self
    {
        $this->NumeroCommande = $NumeroCommande;

        return $this;
    }

    public function getDate(): ?int
    {
        return $this->Date;
    }

    public function setDate(?int $Date): self
    {
        $this->Date = $Date;

        return $this;
    }
}
