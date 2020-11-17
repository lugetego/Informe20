<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plan
 *
 * @ORM\Table(name="plan")
 * @ORM\Entity(repositoryClass="App\Repository\PlanRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Plan
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
     * @var academico
     * @ORM\ManyToOne(targetEntity="Academico", inversedBy="planes")
     * @ORM\JoinColumn(name="academico_id", referencedColumnName="id")
     */
    private $academico;

    /**
     * @var string
     *
     * @ORM\Column(name="investigacion", type="text", length=10000, nullable=true)
     */
    private $investigacion;

    /**
     * @var string
     *
     * @ORM\Column(name="estudiantes", type="text", length=10000, nullable=true)
     */
    private $estudiantes;

    /**
     * @var string
     *
     * @ORM\Column(name="posdocs", type="text", length=10000, nullable=true)
     */
    private $posdocs;

    /**
     * @var string
     *
     * @ORM\Column(name="cursos", type="text", length=10000, nullable=true)
     */
    private $cursos;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectos", type="text", length=10000, nullable=true)
     */
    private $proyectos;

    /**
     * @var string
     *
     * @ORM\Column(name="eventos", type="text", length=10000, nullable=true)
     */
    private $eventos;

    /**
     * @var string
     *
     * @ORM\Column(name="visitantes", type="text", length=10000, nullable=true)
     */
    private $visitantes;

    /**
     * @var bool
     *
     * @ORM\Column(name="enviado", type="boolean", nullable=true)
     */
    private $enviado;

    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=4, nullable=true)
     */
    private $anio;
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
     * Set investigacion
     *
     * @param string $investigacion
     * @return Plan
     */
    public function setInvestigacion($investigacion)
    {
        $this->investigacion = $investigacion;

        return $this;
    }

    /**
     * Get investigacion
     *
     * @return string
     */
    public function getInvestigacion()
    {
        return $this->investigacion;
    }

    /**
     * Set estudiantes
     *
     * @param string $estudiantes
     * @return Plan
     */
    public function setEstudiantes($estudiantes)
    {
        $this->estudiantes = $estudiantes;

        return $this;
    }

    /**
     * Get estudiantes
     *
     * @return string
     */
    public function getEstudiantes()
    {
        return $this->estudiantes;
    }

    /**
     * @return string
     */
    public function getPosdocs()
    {
        return $this->posdocs;
    }

    /**
     * @param string $posdocs
     */
    public function setPosdocs($posdocs)
    {
        $this->posdocs = $posdocs;
    }

    /**
     * Set cursos
     *
     * @param string $cursos
     * @return Plan
     */
    public function setCursos($cursos)
    {
        $this->cursos = $cursos;

        return $this;
    }

    /**
     * Get cursos
     *
     * @return string
     */
    public function getCursos()
    {
        return $this->cursos;
    }

    /**
     * Set proyectos
     *
     * @param string $proyectos
     * @return Plan
     */
    public function setProyectos($proyectos)
    {
        $this->proyectos = $proyectos;

        return $this;
    }

    /**
     * Get proyectos
     *
     * @return string
     */
    public function getProyectos()
    {
        return $this->proyectos;
    }

    /**
     * Set eventos
     *
     * @param string $eventos
     * @return Plan
     */
    public function setEventos($eventos)
    {
        $this->eventos = $eventos;

        return $this;
    }

    /**
     * Get eventos
     *
     * @return string
     */
    public function getEventos()
    {
        return $this->eventos;
    }

    /**
     * Set visitantes
     *
     * @param string $visitantes
     * @return Plan
     */
    public function setVisitantes($visitantes)
    {
        $this->visitantes = $visitantes;

        return $this;
    }

    /**
     * Get visitantes
     *
     * @return string
     */
    public function getVisitantes()
    {
        return $this->visitantes;
    }

    /**
     * Set academico
     *
     * @param \App\Entity\academico $academico
     */
    public function setAcademico($academico)
    {
        $this->academico = $academico;
    }

    /**
     * Get academico
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAcademico()
    {
        return $this->academico;
    }


    /**
     * Set anio
     *
     * @param string $anio
     * @return Plan
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return string
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * @return boolean
     */
    public function isEnviado()
    {
        return $this->enviado;
    }

    /**
     * @param boolean $enviado
     */
    public function setEnviado($enviado)
    {
        $this->enviado = $enviado;
    }
}