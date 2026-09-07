<?php

namespace App\Entity;

use App\Repository\OrientadaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrientadaRepository::class)]
class Orientada
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'orientadas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Legajo $legajo = null;

    #[ORM\ManyToOne(inversedBy: 'orientadas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ciclo $ciclo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTime
    {
        return $this->fecha;
    }

    public function setFecha(\DateTime $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getLegajo(): ?Legajo
    {
        return $this->legajo;
    }

    public function setLegajo(?Legajo $legajo): static
    {
        $this->legajo = $legajo;

        return $this;
    }

    public function getCiclo(): ?Ciclo
    {
        return $this->ciclo;
    }

    public function setCiclo(?Ciclo $ciclo): static
    {
        $this->ciclo = $ciclo;

        return $this;
    }
}
