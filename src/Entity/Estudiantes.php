<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estudiantes
 *
 * @ORM\Table(name="estudiantes")
 * @ORM\Entity(repositoryClass="App\Repository\EstudiantesRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Estudiantes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var informe
     * @ORM\ManyToOne(targetEntity="Informe", inversedBy="estudiantes")
     * @ORM\JoinColumn(name="informe_id", referencedColumnName="id")
     */
    private $informe;

    /**
     * @var string
     *
     * @ORM\Column(name="nivel", type="string", length=255)
     */
    private $nivel;

    /**
     * @var string
     *
     * @ORM\Column(name="programa", type="string", length=255)
     */
    private $programa;

    /**
     * @var string
     *
     * @ORM\Column(name="tesis", type="string", length=255, nullable=true))
     */
    private $tesis;

    /**
     * @var string
     *
     * @ORM\Column(name="alumno", type="string", length=255)
     */
    private $alumno;

    /**
     * @var integer
     *
     * @ORM\Column(name="avance", type="integer", length=3)
     */
    private $avance;

    /**
     * @var bool
     *
     * @ORM\Column(name="titulado", type="boolean")
     */
    private $titulado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="titulacion", type="date", nullable=true)
     */
    private $titulacion;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified;

    /**
     * Set created
     *
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setCreated(new \DateTime());
        $this->setModified(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setModified(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set programa
     *
     * @param string $programa
     * @return Estudiantes
     */
    public function setPrograma($programa)
    {
        $this->programa = $programa;

        return $this;
    }

    /**
     * Get programa
     *
     * @return string
     */
    public function getPrograma()
    {
        return $this->programa;
    }

    /**
     * @return string
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * @param string $nivel
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }

    /**
     * Set tesis
     *
     * @param string $tesis
     * @return Estudiantes
     */
    public function setTesis($tesis)
    {
        $this->tesis = $tesis;

        return $this;
    }

    /**
     * Get tesis
     *
     * @return string
     */
    public function getTesis()
    {
        return $this->tesis;
    }

    /**
     * Set alumno
     *
     * @param string $alumno
     * @return Estudiantes
     */
    public function setAlumno($alumno)
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * Get alumno
     *
     * @return string
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * @return int
     */
    public function getAvance()
    {
        return $this->avance;
    }

    /**
     * @param int $avance
     */
    public function setAvance($avance)
    {
        $this->avance = $avance;
    }

    /**
     * @return boolean
     */
    public function isTitulado()
    {
        return $this->titulado;
    }

    /**
     * @param boolean $titulado
     */
    public function setTitulado($titulado)
    {
        $this->titulado = $titulado;
    }

    /**
     * @return \DateTime
     */
    public function getTitulacion()
    {
        return $this->titulacion;
    }

    /**
     * @param \DateTime $titulacion
     */
    public function setTitulacion($titulacion)
    {
        $this->titulacion = $titulacion;
    }

    /**
     * Get titulado
     *
     * @return boolean
     */
    public function getTitulado()
    {
        return $this->titulado;
    }

    /**
     * Set informe
     *
     * @param \App\Entity\Informe $informe
     * @return Estudiantes
     */
    public function setInforme(\App\Entity\Informe $informe = null)
    {
        $this->informe = $informe;

        return $this;
    }

    /**
     * Get informe
     *
     * @return \App\Entity\Informe
     */
    public function getInforme()
    {
        return $this->informe;
    }
}