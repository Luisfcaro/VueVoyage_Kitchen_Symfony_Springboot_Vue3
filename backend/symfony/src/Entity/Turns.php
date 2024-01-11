<?php

namespace App\Entity;

use App\Repository\TurnsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TurnsRepository::class)]
class Turns
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type_turn = null;

    #[ORM\Column(length: 255)]
    private ?string $hora = null;

    #[ORM\OneToMany(targetEntity: Bookings::class, mappedBy: 'turn')]
    private Collection $bookings;


    
    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeTurn(): ?string
    {
        return $this->type_turn;
    }

    public function setTypeTurn(string $type_turn): static
    {
        $this->type_turn = $type_turn;

        return $this;
    }

    public function getHora(): ?string
    {
        return $this->hora;
    }

    public function setHora(string $hora): static
    {
        $this->hora = $hora;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'type_turn' => $this->getTypeTurn(),
            'hora' => $this->getHora()
        ];
    }
}
