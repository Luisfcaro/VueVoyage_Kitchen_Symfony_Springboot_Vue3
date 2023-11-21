<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: '`categories`')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_cat = null;

    #[ORM\Column(length: 255)]
    private ?string $name_cat = null;

    #[ORM\Column(length: 255)]
    private ?string $img_cat = null;

    public function getIdCat(): ?int
    {
        return $this->id_cat;
    }

    public function getNameCat(): ?string
    {
        return $this->name_cat;
    }

    public function setNameCat(string $name_cat): static
    {
        $this->name_cat = $name_cat;

        return $this;
    }

    public function getImgCat(): ?string
    {
        return $this->img_cat;
    }

    public function setImgCat(string $img_cat): static
    {
        $this->img_cat = $img_cat;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id_cat' => $this->id_cat,
            'name_cat' => $this->name_cat,
            'img_cat' => $this->img_cat,
        ];
    }
}
