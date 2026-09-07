<?php

namespace App\Entity;

use App\Repository\EstudioSecundarioRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EstudioSecundarioRepository::class)]
class EstudioSecundario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5)]
    private ?string $tomo = null;

    #[ORM\Column(length: 5)]
    private ?string $folio = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fecha = null;

    #[ORM\Column(length: 10)]
    private ?string $tipo = null;

    #[ORM\Column(length: 5)]
    private ?string $numero = null;

    #[ORM\Column(length: 50)]
    private ?string $localidad = null;

    #[ORM\Column(length: 25)]
    private ?string $anioCompleto = null;

    #[ORM\Column(length: 50)]
    private ?string $planEstudio = null;

    #[ORM\ManyToOne(inversedBy: 'estudioSecundarios')]
    private ?Legajo $legajo = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFecha(): ?\DateTime
    {
        return $this->fecha;
    }

    public function setFecha(\DateTime $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): static
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getAnioCompleto(): ?string
    {
        return $this->anioCompleto;
    }

    public function setAnioCompleto(string $anioCompleto): static
    {
        $this->anioCompleto = $anioCompleto;

        return $this;
    }

    public function getPlanEstudio(): ?string
    {
        return $this->planEstudio;
    }

    public function setPlanEstudio(string $planEstudio): static
    {
        $this->planEstudio = $planEstudio;

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
