<?php

namespace App\Entity;

use App\Repository\LegajoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LegajoRepository::class)]
class Legajo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1)]
    private ?string $anio = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fecha = null;

    #[ORM\Column(length: 15)]
    private ?string $turno = null;

    /**
     * @var Collection<int, Orientada>
     */
    #[ORM\OneToMany(targetEntity: Orientada::class, mappedBy: 'legajo')]
    private Collection $orientadas;

    /**
     * @var Collection<int, LegajoResolucion>
     */
    #[ORM\OneToMany(targetEntity: LegajoResolucion::class, mappedBy: 'legajo')]
    private Collection $legajoResolucions;

    /**
     * @var Collection<int, LegajoAsignatura>
     */
    #[ORM\OneToMany(targetEntity: LegajoAsignatura::class, mappedBy: 'legajo')]
    private Collection $legajoAsignaturas;

    /**
     * @var Collection<int, LibroNota>
     */
    #[ORM\OneToMany(targetEntity: LibroNota::class, mappedBy: 'legajo')]
    private Collection $libroNotas;

    /**
     * @var Collection<int, LibroMatriz>
     */
    #[ORM\OneToMany(targetEntity: LibroMatriz::class, mappedBy: 'legajo')]
    private Collection $libroMatrizs;

    #[ORM\OneToOne(mappedBy: 'legajo', cascade: ['persist', 'remove'])]
    private ?LibroLegajo $libroLegajo = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Estudiante $estudiante = null;

    #[ORM\ManyToOne(inversedBy: 'legajos')]
    private ?Institucion $institucion = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?Resolucion $resolucion = null;

    #[ORM\ManyToOne(inversedBy: 'legajos')]
    private ?Ciclo $ciclo = null;

    /**
     * @var Collection<int, EstudioSecundario>
     */
    #[ORM\OneToMany(targetEntity: EstudioSecundario::class, mappedBy: 'legajo')]
    private Collection $estudioSecundarios;


    public function __construct()
    {
        $this->orientadas = new ArrayCollection();
        $this->legajoResolucions = new ArrayCollection();
        $this->legajoAsignaturas = new ArrayCollection();
        $this->libroNotas = new ArrayCollection();
        $this->libroMatrizs = new ArrayCollection();
        $this->estudioSecundarios = new ArrayCollection();
    }


    public function getId(): ?int
        {
            return $this->id;
        }

    public function getLibroLegajo(): ?LibroLegajo
    {
        return $this->libroLegajo;
    }
    public function setLibroLegajo(?LibroLegajo $libroLegajo): static
    {
        $this->libroLegajo = $libroLegajo;

        if ($libroLegajo !== null && $libroLegajo->getLegajo() !== $this) {
            $libroLegajo->setLegajo($this);
        }

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

    public function getFecha(): ?\DateTime
    {
        return $this->fecha;
    }

    public function setFecha(\DateTime $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getTurno(): ?string
    {
        return $this->turno;
    }

    public function setTurno(string $turno): static
    {
        $this->turno = $turno;

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
            $orientada->setLegajo($this);
        }

        return $this;
    }

    public function removeOrientada(Orientada $orientada): static
    {
        if ($this->orientadas->removeElement($orientada)) {
            // set the owning side to null (unless already changed)
            if ($orientada->getLegajo() === $this) {
                $orientada->setLegajo(null);
            }
        }

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
            $legajoResolucion->setLegajo($this);
        }

        return $this;
    }

    public function removeLegajoResolucion(LegajoResolucion $legajoResolucion): static
    {
        if ($this->legajoResolucions->removeElement($legajoResolucion)) {
            // set the owning side to null (unless already changed)
            if ($legajoResolucion->getLegajo() === $this) {
                $legajoResolucion->setLegajo(null);
            }
        }

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
            $legajoAsignatura->setLegajo($this);
        }

        return $this;
    }

    public function removeLegajoAsignatura(LegajoAsignatura $legajoAsignatura): static
    {
        if ($this->legajoAsignaturas->removeElement($legajoAsignatura)) {
            // set the owning side to null (unless already changed)
            if ($legajoAsignatura->getLegajo() === $this) {
                $legajoAsignatura->setLegajo(null);
            }
        }

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
            $libroNota->setLegajo($this);
        }

        return $this;
    }

    public function removeLibroNota(LibroNota $libroNota): static
    {
        if ($this->libroNotas->removeElement($libroNota)) {
            // set the owning side to null (unless already changed)
            if ($libroNota->getLegajo() === $this) {
                $libroNota->setLegajo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LibroMatriz>
     */
    public function getLibroMatrizs(): Collection
    {
        return $this->libroMatrizs;
    }

    public function addLibroMatriz(LibroMatriz $libroMatriz): static
    {
        if (!$this->libroMatrizs->contains($libroMatriz)) {
            $this->libroMatrizs->add($libroMatriz);
            $libroMatriz->setLegajo($this);
        }

        return $this;
    }

    public function removeLibroMatriz(LibroMatriz $libroMatriz): static
    {
        if ($this->libroMatrizs->removeElement($libroMatriz)) {
            // set the owning side to null (unless already changed)
            if ($libroMatriz->getLegajo() === $this) {
                $libroMatriz->setLegajo(null);
            }
        }

        return $this;
    }

    public function getEstudiante(): ?Estudiante
    {
        return $this->estudiante;
    }

    public function setEstudiante(?Estudiante $estudiante): static
    {
        $this->estudiante = $estudiante;

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

    public function getResolucion(): ?Resolucion
    {
        return $this->resolucion;
    }

    public function setResolucion(?Resolucion $resolucion): static
    {
        $this->resolucion = $resolucion;

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

    /**
     * @return Collection<int, EstudioSecundario>
     */
    public function getEstudioSecundarios(): Collection
    {
        return $this->estudioSecundarios;
    }

    public function addEstudioSecundario(EstudioSecundario $estudioSecundario): static
    {
        if (!$this->estudioSecundarios->contains($estudioSecundario)) {
            $this->estudioSecundarios->add($estudioSecundario);
            $estudioSecundario->setLegajo($this);
        }

        return $this;
    }

    public function removeEstudioSecundario(EstudioSecundario $estudioSecundario): static
    {
        if ($this->estudioSecundarios->removeElement($estudioSecundario)) {
            // set the owning side to null (unless already changed)
            if ($estudioSecundario->getLegajo() === $this) {
                $estudioSecundario->setLegajo(null);
            }
        }

        return $this;
    }


}
