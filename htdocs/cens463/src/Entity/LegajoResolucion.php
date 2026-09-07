<?php

namespace App\Entity;

use App\Repository\LegajoResolucionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LegajoResolucionRepository::class)]
class LegajoResolucion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'legajoResolucions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Resolucion $resolucion = null;

    #[ORM\ManyToOne(inversedBy: 'legajoResolucions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Legajo $legajo = null;

    /**
     * @var Collection<int, LegajoAsignatura>
     */
    #[ORM\OneToMany(targetEntity: LegajoAsignatura::class, mappedBy: 'legajoResolucion')]
    private Collection $legajoAsignaturas;

    public function __construct()
    {
        $this->legajoAsignaturas = new ArrayCollection();
    }

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

    public function getResolucion(): ?Resolucion
    {
        return $this->resolucion;
    }

    public function setResolucion(?Resolucion $resolucion): static
    {
        $this->resolucion = $resolucion;

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
            $legajoAsignatura->setLegajoResolucion($this);
        }

        return $this;
    }

    public function removeLegajoAsignatura(LegajoAsignatura $legajoAsignatura): static
    {
        if ($this->legajoAsignaturas->removeElement($legajoAsignatura)) {
            // set the owning side to null (unless already changed)
            if ($legajoAsignatura->getLegajoResolucion() === $this) {
                $legajoAsignatura->setLegajoResolucion(null);
            }
        }

        return $this;
    }
}
