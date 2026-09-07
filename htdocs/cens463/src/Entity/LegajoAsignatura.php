<?php

namespace App\Entity;

use App\Repository\LegajoAsignaturaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LegajoAsignaturaRepository::class)]
class LegajoAsignatura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'legajoAsignaturas')]
    private ?Legajo $legajo = null;

    #[ORM\ManyToOne(inversedBy: 'legajoAsignaturas')]
    private ?Asignatura $asignatura = null;

    #[ORM\ManyToOne(inversedBy: 'legajoAsignaturas')]
    private ?LegajoResolucion $legajoResolucion = null;

    /**
     * @var Collection<int, LibroNota>
     */
    #[ORM\OneToMany(targetEntity: LibroNota::class, mappedBy: 'legajoAsignatura')]
    private Collection $libroNotas;

    public function __construct()
    {
        $this->libroNotas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAsignatura(): ?Asignatura
    {
        return $this->asignatura;
    }

    public function setAsignatura(?Asignatura $asignatura): static
    {
        $this->asignatura = $asignatura;

        return $this;
    }

    public function getLegajoResolucion(): ?LegajoResolucion
    {
        return $this->legajoResolucion;
    }

    public function setLegajoResolucion(?LegajoResolucion $legajoResolucion): static
    {
        $this->legajoResolucion = $legajoResolucion;

        return $this;
    }

    /**
     * @return Collection<int, LibroNota>
     */
    public function getLibroNotas(): Collection
    {
        return $this->libroNotas;
    }

    public function addLibroNota(LibroNota $libroNota): static
    {
        if (!$this->libroNotas->contains($libroNota)) {
            $this->libroNotas->add($libroNota);
            $libroNota->setLegajoAsignatura($this);
        }

        return $this;
    }

    public function removeLibroNota(LibroNota $libroNota): static
    {
        if ($this->libroNotas->removeElement($libroNota)) {
            // set the owning side to null (unless already changed)
            if ($libroNota->getLegajoAsignatura() === $this) {
                $libroNota->setLegajoAsignatura(null);
            }
        }

        return $this;
    }

}
