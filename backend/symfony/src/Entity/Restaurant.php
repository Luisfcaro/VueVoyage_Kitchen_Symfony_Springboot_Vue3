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
    private ?int $id_rest = null;

    #[ORM\Column(length: 255)]
    private ?string $name_rest = null;

    #[ORM\Column(length: 255)]
    private ?string $img_rest = null;

    #[ORM\Column(length: 255)]
    private ?string $location_rest = null;

    #[ORM\OneToMany(targetEntity: Tables::class, mappedBy: 'tables')]
    private Collection $tables;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categories", inversedBy="restaurants")
     * @ORM\JoinTable(name="rest_cat",
     *   joinColumns={@ORM\JoinColumn(name="id_rest", referencedColumnName="id_rest")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="id_cat", referencedColumnName="id_cat")}
     * )
     */
    private $categories;

    public function __construct()
    {
        $this->tables = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getIdRest(): ?int
    {
        return $this->id_rest;
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
     * @return Collection<int, Tables>
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }


    /**
     * @return Collection|Categories[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function toArray(): array
    {
        return [
            'id_rest' => $this->getIdRest(),
            'name_rest' => $this->getNameRest(),
            'img_rest' => $this->getImgRest(),
            'location_rest' => $this->getLocationRest()
        ];
    }
}
