<?php

namespace App\Entity;

use App\Repository\TablesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TablesRepository::class)]
#[ORM\Table(name: '`tables`')]
class Tables
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_table = null;

    #[ORM\Column]
    private ?int $num_table = null;

    #[ORM\Column]
    private ?int $id_rest = null;

    #[ORM\Column]
    private ?int $capacity_table = null;

    #[ORM\Column(length: 50)]
    private ?string $status_table = null;

    public function getIdTable(): ?int
    {
        return $this->id_table;
    }

    public function getNumTable(): ?int
    {
        return $this->num_table;
    }

    public function setNumTable(int $num_table): static
    {
        $this->num_table = $num_table;

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

    public function getCapacityTable(): ?int
    {
        return $this->capacity_table;
    }

    public function setCapacityTable(int $capacity_table): static
    {
        $this->capacity_table = $capacity_table;

        return $this;
    }

    public function getStatusTable(): ?string
    {
        return $this->status_table;
    }

    public function setStatusTable(string $status_table): static
    {
        $this->status_table = $status_table;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id_table' => $this->getIdTable(),
            'num_table' => $this->getNumTable(),
            'id_rest' => $this->getIdRest(),
            'capacity_table' => $this->getCapacityTable(),
            'status_table' => $this->getStatusTable(),
        ];
    }
}
