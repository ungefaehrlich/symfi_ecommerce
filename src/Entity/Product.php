<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ApiResource(
 *     collectionOperations={"get"={"normalization_context"={"groups"="product:list"}}},
 *     itemOperations={"get"={"normalization_context"={"groups"="product:item"}}},
 *     paginationEnabled=false
 * )
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"product:list", "product:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1024)
     * @Groups({"product:list", "product:item"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"product:list", "product:item"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=1024)
     * @Groups({"product:list", "product:item"})
     */
    private $picture;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"product:list", "product:item"})
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"product:list", "product:item"})
     */
    private $stock;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"product:list", "product:item"})
     */
    private $is_offer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getIsOffer(): ?bool
    {
        return $this->is_offer;
    }

    public function setIsOffer(bool $is_offer): self
    {
        $this->is_offer = $is_offer;

        return $this;
    }
}
