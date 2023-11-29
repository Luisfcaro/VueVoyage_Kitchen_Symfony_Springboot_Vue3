<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
#[ORM\Table(name: '`restaurant`')]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_rest = null;

    #[ORM\Column(length: 255)]
    private ?string $img_rest = null;

    #[ORM\Column(length: 255)]
    private ?string $location_rest = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'restaurant')]
    private Collection $categories;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getIdRest(): ?int
    {
        return $this->id;
    }

    public function getNameRest(): ?string
    {
        return $this->name_rest;
    }

    public function setNameRest(string $name_rest): static
    {
        $this->name_rest = $name_rest;

        return $this;
    }

    public function getImgRest(): ?string
    {
        return $this->img_rest;
    }

    public function setImgRest(string $img_rest): static
    {
        $this->img_rest = $img_rest;

        return $this;
    }

    public function getLocationRest(): ?string
    {
        return $this->location_rest;
    }

    public function setLocationRest(string $location_rest): static
    {
        $this->location_rest = $location_rest;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id_rest' => $this->id,
            'name_rest' => $this->name_rest,
            'img_rest' => $this->img_rest,
            'location_rest' => $this->location_rest
        ];
    }
}
