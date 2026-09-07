<?php

namespace App\Entity;

use App\Repository\ResolucionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResolucionRepository::class)]
class Resolucion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $numero = null;

    /**
     * @var Collection<int, LegajoResolucion>
     */
    #[ORM\OneToMany(targetEntity: LegajoResolucion::class, mappedBy: 'resolucion')]
    private Collection $legajoResolucions;

    #[ORM\ManyToOne(inversedBy: 'resolucions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Institucion $institucion = null;

    /**
     * @var Collection<int, Asignatura>
     */
    #[ORM\OneToMany(targetEntity: Asignatura::class, mappedBy: 'resolucion')]
    private Collection $asignaturas;

    /**
     * @var Collection<int, Ciclo>
     */
    #[ORM\OneToMany(targetEntity: Ciclo::class, mappedBy: 'resolucion')]
    private Collection $ciclos;

    public function __construct()
    {
        $this->legajoResolucions = new ArrayCollection();
        $this->asignaturas = new ArrayCollection();
        $this->ciclos = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, LegajoResolucion>
     */
    public function getLegajoResolucions(): Collection
    {
        return $this->legajoResolucions;
    }

    public function addLegajoResolucion(LegajoResolucion $legajoResolucion): static
    {
        if (!$this->legajoResolucions->contains($legajoResolucion)) {
            $this->legajoResolucions->add($legajoResolucion);
            $legajoResolucion->setResolucion($this);
        }

        return $this;
    }

    public function removeLegajoResolucion(LegajoResolucion $legajoResolucion): static
    {
        if ($this->legajoResolucions->removeElement($legajoResolucion)) {
            // set the owning side to null (unless already changed)
            if ($legajoResolucion->getResolucion() === $this) {
                $legajoResolucion->setResolucion(null);
            }
        }

        return $this;
    }

    public function getInstitucion(): ?Institucion
    {
        return $this->institucion;
    }

    public function setInstitucion(?Institucion $institucion): static
    {
        $this->institucion = $institucion;

        return $this;
    }

    /**
     * @return Collection<int, Asignatura>
     */
    public function getAsignaturas(): Collection
    {
        return $this->asignaturas;
    }

    public function addAsignatura(Asignatura $asignatura): static
    {
        if (!$this->asignaturas->contains($asignatura)) {
            $this->asignaturas->add($asignatura);
            $asignatura->setResolucion($this);
        }

        return $this;
    }

    public function removeAsignatura(Asignatura $asignatura): static
    {
        if ($this->asignaturas->removeElement($asignatura)) {
            // set the owning side to null (unless already changed)
            if ($asignatura->getResolucion() === $this) {
                $asignatura->setResolucion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ciclo>
     */
    public function getCiclos(): Collection
    {
        return $this->ciclos;
    }

    public function addCiclo(Ciclo $ciclo): static
    {
        if (!$this->ciclos->contains($ciclo)) {
            $this->ciclos->add($ciclo);
            $ciclo->setResolucion($this);
        }

        return $this;
    }

    public function removeCiclo(Ciclo $ciclo): static
    {
        if ($this->ciclos->removeElement($ciclo)) {
            // set the owning side to null (unless already changed)
            if ($ciclo->getResolucion() === $this) {
                $ciclo->setResolucion(null);
            }
        }

        return $this;
    }
}
