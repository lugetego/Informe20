<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eventos
 *
 * @ORM\Table(name="eventos")
 * @ORM\Entity(repositoryClass="App\Repository\EventosRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Eventos
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
     * @ORM\ManyToOne(targetEntity="Informe", inversedBy="eventos")
     * @ORM\JoinColumn(name="informe_id", referencedColumnName="id")
     */
    private $informe;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoActividad", type="string", length=255)
     */
    private $tipoActividad;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=20, nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="anfitrion", type="string", length=255, nullable=true)
     */
    private $anfitrion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreEvento", type="string", length=255, nullable=true)
     */
    private $nombreEvento;

    /**
     * @var string
     *
     * @ORM\Column(name="tituloTrabajo", type="string", length=255, nullable=true)
     */
    private $tituloTrabajo;

    /**
     * @var bool
     *
     * @ORM\Column(name="nacional", type="boolean", nullable=true)
     */
    private $nacional;

    /**
     * @var string
     *
     * @ORM\Column(name="plenaria", type="boolean", nullable=true)
     */
    private $plenaria;

    /**
     * @var string
     *
     * @ORM\Column(name="invitacion", type="boolean", nullable=true)
     */
    private $invitacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="sinodalGrado", type="string", length=255, nullable=true)
     */
    private $sinodalGrado;

    /**
     * @var string
     *
     * @ORM\Column(name="sinodalAlumno", type="string", length=255, nullable=true)
     */
    private $sinodalAlumno;

    /**
     * @var string
     *
     * @ORM\Column(name="motivo", type="array", length=255, nullable=true)
     */
    private $motivo;

    /**
     * @var string
     *
     * @ORM\Column(name="institucion", type="string", length=255, nullable=true)
     */
    private $institucion;

    /**
     * @var string
     *
     * @ORM\Column(name="departamento", type="string", length=255, nullable=true)
     */
    private $departamento;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar", type="string", length=255, nullable=true)
     */
    private $lugar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInicio", type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFin", type="date", nullable=true)
     */
    private $fechaFin;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=1000, nullable=true)
     */
    private $observaciones;

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
     * Set tipo
     *
     * @param string $tipo
     * @return Eventos
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set tipoActividad
     *
     * @param string $tipoActividad
     * @return Eventos
     */
    public function setTipoActividad($tipoActividad)
    {
        $this->tipoActividad = $tipoActividad;

        return $this;
    }

    /**
     * Get tipoActividad
     *
     * @return string
     */
    public function getTipoActividad()
    {
        return $this->tipoActividad;
    }


    /**
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * Set anfitrion
     *
     * @param string $anfitrion
     * @return Eventos
     */
    public function setAnfitrion($anfitrion)
    {
        $this->anfitrion = $anfitrion;

        return $this;
    }

    /**
     * Get anfitrion
     *
     * @return string
     */
    public function getAnfitrion()
    {
        return $this->anfitrion;
    }

    /**
     * Set nombreEvento
     *
     * @param string $nombreEvento
     * @return Eventos
     */
    public function setNombreEvento($nombreEvento)
    {
        $this->nombreEvento = $nombreEvento;

        return $this;
    }

    /**
     * Get nombreEvento
     *
     * @return string
     */
    public function getNombreEvento()
    {
        return $this->nombreEvento;
    }

    /**
     * Set tituloTrabajo
     *
     * @param string $tituloTrabajo
     * @return Eventos
     */
    public function setTituloTrabajo($tituloTrabajo)
    {
        $this->tituloTrabajo = $tituloTrabajo;

        return $this;
    }

    /**
     * Get tituloTrabajo
     *
     * @return string
     */
    public function getTituloTrabajo()
    {
        return $this->tituloTrabajo;
    }

    /**
     * Set nacional
     *
     * @param boolean $nacional
     * @return Eventos
     */
    public function setNacional($nacional)
    {
        $this->nacional = $nacional;

        return $this;
    }

    /**
     * Get nacional
     *
     * @return boolean
     */
    public function getNacional()
    {
        return $this->nacional;
    }

    /**
     * @return string
     */
    public function getPlenaria()
    {
        return $this->plenaria;
    }

    /**
     * @param string $plenaria
     */
    public function setPlenaria($plenaria)
    {
        $this->plenaria = $plenaria;
    }

    /**
     * @return string
     */
    public function getInvitacion()
    {
        return $this->invitacion;
    }

    /**
     * @param string $invitacion
     */
    public function setInvitacion($invitacion)
    {
        $this->invitacion = $invitacion;
    }

    /**
     * Set sinodalGrado
     *
     * @param string $sinodalGrado
     * @return Eventos
     */
    public function setSinodalGrado($sinodalGrado)
    {
        $this->sinodalGrado = $sinodalGrado;

        return $this;
    }

    /**
     * Get sinodalGrado
     *
     * @return string
     */
    public function getSinodalGrado()
    {
        return $this->sinodalGrado;
    }

    /**
     * Set sinodalAlumno
     *
     * @param string $sinodalAlumno
     * @return Eventos
     */
    public function setSinodalAlumno($sinodalAlumno)
    {
        $this->sinodalAlumno = $sinodalAlumno;

        return $this;
    }

    /**
     * Get sinodalAlumno
     *
     * @return string
     */
    public function getSinodalAlumno()
    {
        return $this->sinodalAlumno;
    }


    /**
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * @param string $motivo
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
    }

    /**
     * @return string
     */
    public function getInstitucion()
    {
        return $this->institucion;
    }

    /**
     * @param string $institucion
     */
    public function setInstitucion($institucion)
    {
        $this->institucion = $institucion;
    }

    /**
     * @return string
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * @param string $departamento
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }

    /**
     * @return string
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * @param string $lugar
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
    }

    /**
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * @param \DateTime $fechaInicio
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

    /**
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * @param \DateTime $fechaFin
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;
    }

    /**
     * Set informe
     *
     * @param \App\Entity\Informe $informe
     * @return Eventos
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

    /**
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param string $observaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }


}