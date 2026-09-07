<?php

namespace App\Entity;

use App\Repository\InstitucionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstitucionRepository::class)]
class Institucion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(length: 5)]
    private ?string $numero = null;

    #[ORM\Column(length: 25)]
    private ?string $cue = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fecha = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    /**
     * @var Collection<int, Resolucion>
     */
    #[ORM\OneToMany(targetEntity: Resolucion::class, mappedBy: 'institucion')]
    private Collection $resolucions;

    /**
     * @var Collection<int, Legajo>
     */
    #[ORM\OneToMany(targetEntity: Legajo::class, mappedBy: 'institucion')]
    private Collection $legajos;

    public function __construct()
    {
        $this->resolucions = new ArrayCollection();
        $this->legajos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

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

    public function getCue(): ?string
    {
        return $this->cue;
    }

    public function setCue(string $cue): static
    {
        $this->cue = $cue;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Resolucion>
     */
    public function getResolucions(): Collection
    {
        return $this->resolucions;
    }

    public function addResolucion(Resolucion $resolucion): static
    {
        if (!$this->resolucions->contains($resolucion)) {
            $this->resolucions->add($resolucion);
            $resolucion->setInstitucion($this);
        }

        return $this;
    }

    public function removeResolucion(Resolucion $resolucion): static
    {
        if ($this->resolucions->removeElement($resolucion)) {
            // set the owning side to null (unless already changed)
            if ($resolucion->getInstitucion() === $this) {
                $resolucion->setInstitucion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Legajo>
     */
    public function getLegajos(): Collection
    {
        return $this->legajos;
    }

    public function addLegajo(Legajo $legajo): static
    {
        if (!$this->legajos->contains($legajo)) {
            $this->legajos->add($legajo);
            $legajo->setInstitucion($this);
        }

        return $this;
    }

    public function removeLegajo(Legajo $legajo): static
    {
        if ($this->legajos->removeElement($legajo)) {
            // set the owning side to null (unless already changed)
            if ($legajo->getInstitucion() === $this) {
                $legajo->setInstitucion(null);
            }
        }

        return $this;
    }
}
