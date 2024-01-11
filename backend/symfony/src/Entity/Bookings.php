<?php

namespace App\Entity;

use App\Repository\BookingsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingsRepository::class)]
#[ORM\Table(name: '`bookings`')]
class Bookings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_user = null;

    #[ORM\Column]
    private ?int $id_rest = null;

    #[ORM\Column]
    private ?int $id_turn = null;

    #[ORM\Column]
    private ?int $people = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\Column (type: 'date')]
    private ?\DateTime $date = null;
    

    #[ORM\ManyToMany(targetEntity: Tables::class, inversedBy: 'bookings')]
    #[ORM\JoinTable(name: "bookings_tables", 
                    joinColumns: [new ORM\JoinColumn(name: "id_booking", referencedColumnName: "id")], 
                    inverseJoinColumns: [new ORM\JoinColumn(name: "id_table", referencedColumnName: "id_table")]
    )]
    private Collection $tables;


    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id")]
    private ?Users $user;

    #[ORM\ManyToOne(targetEntity: Turns::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(name: "id_turn", referencedColumnName: "id")]
    private ?Turns $turn;

    #[ORM\ManyToOne(targetEntity: Restaurant::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(name: "id_rest", referencedColumnName: "id")]
    private ?Restaurant $restaurant;


    public function __construct()
    {
        $this->tables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdRest(): ?int
    {
        return $this->id_rest;
    }

    public function setIdRest(int $id_rest): static
    {
        $this->id_rest = $id_rest;

        return $this;
    }

    public function getIdTurn(): ?int
    {
        return $this->id_turn;
    }

    public function setIdTurn(int $id_turn): static
    {
        $this->id_turn = $id_turn;

        return $this;
    }

    public function getPeople(): ?int
    {
        return $this->people;
    }

    public function setPeople(int $people): static
    {
        $this->people = $people;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date_booking): static
    {
        $this->date = $date_booking;

        return $this;
    }


    /////////////////////////////////

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    /////////////////////////////////

    public function getTurn(): ?Turns
    {
        return $this->turn;
    }

    public function setTurn(?Turns $turn): static
    {
        $this->turn = $turn;

        return $this;
    }

    /////////////////////////////////

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): static
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /////////////////////////////////

    /**
     * @return Collection<int, Tables>
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(Tables $table): static
    {
        if (!$this->tables->contains($table)) {
            $this->tables->add($table);
        }

        return $this;
    }

    public function removeTable(Tables $table): static
    {
        $this->tables->removeElement($table);
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'id_user' => $this->getIdUser(),
            'id_rest' => $this->getIdRest(),
            'id_turn' => $this->getIdTurn(),
            'people' => $this->getPeople(),
            'state' => $this->getState(),
            'date' => $this->getDate(),
        ];
    }
}
