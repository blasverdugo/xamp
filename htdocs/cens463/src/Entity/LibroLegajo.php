<?php

namespace App\Entity;

use App\Repository\LibroLegajoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibroLegajoRepository::class)]
class LibroLegajo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $tomo = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $folio = null;

    #[ORM\Column(nullable: true)]
    private ?bool $partida = null;

    #[ORM\Column(nullable: true)]
    private ?bool $dni = null;

    #[ORM\Column(nullable: true)]
    private ?bool $tituloPrimario = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Legajo $legajo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTomo(): ?string
    {
        return $this->tomo;
    }

    public function setTomo(?string $tomo): static
    {
        $this->tomo = $tomo;

        return $this;
    }

    public function getFolio(): ?string
    {
        return $this->folio;
    }

    public function setFolio(?string $folio): static
    {
        $this->folio = $folio;

        return $this;
    }

    public function isPartida(): ?bool
    {
        return $this->partida;
    }

    public function setPartida(?bool $partida): static
    {
        $this->partida = $partida;

        return $this;
    }

    public function isDni(): ?bool
    {
        return $this->dni;
    }

    public function setDni(?bool $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function isTituloPrimario(): ?bool
    {
        return $this->tituloPrimario;
    }

    public function setTituloPrimario(?bool $tituloPrimario): static
    {
        $this->tituloPrimario = $tituloPrimario;

        return $this;
    }

    public function getLegajo(): ?Legajo
    {
        return $this->legajo;
    }

    public function setLegajo(?Legajo $legajo): static
    {
        $this->legajo = $legajo;
        if ($legajo !== null && $legajo->getLibroLegajo() !== $this) {
            $legajo->setLibroLegajo($this);
        }
        return $this;
    }
}
