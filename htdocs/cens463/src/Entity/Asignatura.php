<?php

namespace App\Entity;

use App\Repository\AsignaturaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AsignaturaRepository::class)]
class Asignatura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(length: 1)]
    private ?string $anio = null;

    #[ORM\Column(length: 25)]
    private ?string $duracion = null;

    #[ORM\ManyToOne(inversedBy: 'asignaturas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ciclo $ciclo = null;

    #[ORM\ManyToOne(inversedBy: 'asignaturas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Resolucion $resolucion = null;

    /**
     * @var Collection<int, LegajoAsignatura>
     */
    #[ORM\OneToMany(targetEntity: LegajoAsignatura::class, mappedBy: 'asignatura')]
    private Collection $legajoAsignaturas;

    public function __construct()
    {
        $this->legajoAsignaturas = new ArrayCollection();
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

    public function getAnio(): ?string
    {
        return $this->anio;
    }

    public function setAnio(string $anio): static
    {
        $this->anio = $anio;

        return $this;
    }

    public function getDuracion(): ?string
    {
        return $this->duracion;
    }

    public function setDuracion(string $duracion): static
    {
        $this->duracion = $duracion;

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

    public function getResolucion(): ?Resolucion
    {
        return $this->resolucion;
    }

    public function setResolucion(?Resolucion $resolucion): static
    {
        $this->resolucion = $resolucion;

        return $this;
    }

    /**
     * @return Collection<int, LegajoAsignatura>
     */
    public function getLegajoAsignaturas(): Collection
    {
        return $this->legajoAsignaturas;
    }

    public function addLegajoAsignatura(LegajoAsignatura $legajoAsignatura): static
    {
        if (!$this->legajoAsignaturas->contains($legajoAsignatura)) {
            $this->legajoAsignaturas->add($legajoAsignatura);
            $legajoAsignatura->setAsignatura($this);
        }

        return $this;
    }

    public function removeLegajoAsignatura(LegajoAsignatura $legajoAsignatura): static
    {
        if ($this->legajoAsignaturas->removeElement($legajoAsignatura)) {
            // set the owning side to null (unless already changed)
            if ($legajoAsignatura->getAsignatura() === $this) {
                $legajoAsignatura->setAsignatura(null);
            }
        }

        return $this;
    }
}
