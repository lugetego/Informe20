<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AcademicoRepository")
 */
class Academico
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="nombre", type="string", length=120, nullable=false)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Informe", mappedBy="academico", cascade={"persist"})
     */
    private $informes;


    public function __construct() {
        $this->informes = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * @ORM\Column(name="apellido", type="string", length=120, nullable=false)
     */
    private $apellido;

    /**
     * @ORM\Column(name="nacimiento", type="date", nullable=false)
     */
    private $nacimiento;

    /**
     * @ORM\Column(name="rfc", type="string", length=13, nullable=false)
     */
    private $rfc;

    /**
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="academico")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified;

    /**
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getNacimiento(): ?\DateTimeInterface
    {
        return $this->nacimiento;
    }

    public function setNacimiento(\DateTimeInterface $nacimiento): self
    {
        $this->nacimiento = $nacimiento;

        return $this;
    }

    public function getRfc(): ?string
    {
        return $this->rfc;
    }

    public function setRfc(string $rfc): self
    {
        $this->rfc = $rfc;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getModified(): ?\DateTimeInterface
    {
        return $this->modified;
    }

    public function setModified(\DateTimeInterface $modified): self
    {
        $this->modified = $modified;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }


    /**
     * Add informes
     *
     * @param \App\Entity\Informe $informes
     * @return Academico
     */
    public function addInforme(\App\Entity\Informe $informes)
    {
        $this->informes[] = $informes;

        return $this;
    }

    /**
     * Remove informes
     *
     * @param \App\Entity\Informe $informes
     */
    public function removeInforme(\App\Entity\Informe $informes)
    {
        $this->informes->removeElement($informes);
    }

    /**
     * Get informes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInformes()
    {
        return $this->informes;
    }
    /**
     * @var array $planes
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Plan", mappedBy="academico")
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $planes;

    /**
     * Add planes
     *
     * @param \App\Entity\Plan $planes
     * @return Academico
     */
    public function addPlane(\App\Entity\Plan $planes)
    {
        $this->planes[] = $planes;

        return $this;
    }

    /**
     * Remove planes
     *
     * @param \App\Entity\Plan $planes
     */
    public function removePlane(\App\Entity\Plan $planes)
    {
        $this->planes->removeElement($planes);
    }

    /**
     * Get planes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlanes()
    {
        return $this->planes;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     * @return Academico
     */
    public function setUser(\App\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __toString()
    {
        return $this->nombre;

    }
}
