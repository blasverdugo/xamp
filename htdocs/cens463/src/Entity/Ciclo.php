<?php

namespace App\Entity;

use App\Repository\CicloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CicloRepository::class)]
class Ciclo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(length: 10)]
    private ?string $tipo = null;

    /**
     * @var Collection<int, Orientada>
     */
    #[ORM\OneToMany(targetEntity: Orientada::class, mappedBy: 'ciclo')]
    private Collection $orientadas;

    /**
     * @var Collection<int, Asignatura>
     */
    #[ORM\OneToMany(targetEntity: Asignatura::class, mappedBy: 'ciclo')]
    private Collection $asignaturas;

    /**
     * @var Collection<int, Legajo>
     */
    #[ORM\OneToMany(targetEntity: Legajo::class, mappedBy: 'ciclo')]
    private Collection $legajos;

    #[ORM\ManyToOne(inversedBy: 'ciclos')]
    private ?Resolucion $resolucion = null;

    public function __construct()
    {
        $this->orientadas = new ArrayCollection();
        $this->asignaturas = new ArrayCollection();
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

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return Collection<int, Orientada>
     */
    public function getOrientadas(): Collection
    {
        return $this->orientadas;
    }

    public function addOrientada(Orientada $orientada): static
    {
        if (!$this->orientadas->contains($orientada)) {
            $this->orientadas->add($orientada);
            $orientada->setCiclo($this);
        }

        return $this;
    }

    public function removeOrientada(Orientada $orientada): static
    {
        if ($this->orientadas->removeElement($orientada)) {
            // set the owning side to null (unless already changed)
            if ($orientada->getCiclo() === $this) {
                $orientada->setCiclo(null);
            }
        }

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
            $asignatura->setCiclo($this);
        }

        return $this;
    }

    public function removeAsignatura(Asignatura $asignatura): static
    {
        if ($this->asignaturas->removeElement($asignatura)) {
            // set the owning side to null (unless already changed)
            if ($asignatura->getCiclo() === $this) {
                $asignatura->setCiclo(null);
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
            $legajo->setCiclo($this);
        }

        return $this;
    }

    public function removeLegajo(Legajo $legajo): static
    {
        if ($this->legajos->removeElement($legajo)) {
            // set the owning side to null (unless already changed)
            if ($legajo->getCiclo() === $this) {
                $legajo->setCiclo(null);
            }
        }

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
}
