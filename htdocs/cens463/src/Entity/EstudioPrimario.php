<?php

namespace App\Entity;

use App\Repository\EstudioPrimarioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EstudioPrimarioRepository::class)]
class EstudioPrimario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $numero = null;

    #[ORM\Column(length: 50)]
    private ?string $localidad = null;

    #[ORM\Column(length: 1)]
    private ?string $anioFinalizado = null;

    #[ORM\Column(length: 4)]
    private ?string $egreso = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Legajo $legajo = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAnioFinalizado(): ?string
    {
        return $this->anioFinalizado;
    }

    public function setAnioFinalizado(string $anioFinalizado): static
    {
        $this->anioFinalizado = $anioFinalizado;

        return $this;
    }

    public function getEgreso(): ?string
    {
        return $this->egreso;
    }

    public function setEgreso(string $egreso): static
    {
        $this->egreso = $egreso;

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
