<?php

namespace App\Entity;

use App\Repository\LibroNotaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibroNotaRepository::class)]
class LibroNota
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $nota = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fecha = null;

    #[ORM\Column(length: 5)]
    private ?string $tomo = null;

    #[ORM\Column(length: 5)]
    private ?string $folio = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $observaciones = null;

    #[ORM\ManyToOne(inversedBy: 'libroNotas')]
    private ?LegajoAsignatura $legajoAsignatura = null;

    #[ORM\ManyToOne(inversedBy: 'libroNotas')]
    private ?Legajo $legajo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNota(): ?float
    {
        return $this->nota;
    }

    public function setNota(float $nota): static
    {
        $this->nota = $nota;

        return $this;
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

    public function getTomo(): ?string
    {
        return $this->tomo;
    }

    public function setTomo(string $tomo): static
    {
        $this->tomo = $tomo;

        return $this;
    }

    public function getFolio(): ?string
    {
        return $this->folio;
    }

    public function setFolio(string $folio): static
    {
        $this->folio = $folio;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): static
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getLegajoAsignatura(): ?LegajoAsignatura
    {
        return $this->legajoAsignatura;
    }

    public function setLegajoAsignatura(?LegajoAsignatura $legajoAsignatura): static
    {
        $this->legajoAsignatura = $legajoAsignatura;

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
}
