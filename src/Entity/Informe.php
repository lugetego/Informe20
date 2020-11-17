<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * Informe
 *
 * @ORM\Table(name="informe")
 * @ORM\Entity(repositoryClass="App\Repository\InformeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Informe
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
     * @ORM\ManyToOne(targetEntity="Academico", inversedBy="informes")
     * @ORM\JoinColumn(name="academico_id", referencedColumnName="id")
     */
    private $academico;

    /**
     * @var bool
     *
     * @ORM\Column(name="enviado", type="boolean", nullable=true)
     */
    private $enviado;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $dictamen;

    /**
     * @ORM\Column(type="text",  nullable=true)
     */
    protected $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=255)
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
     * @var array $cursos
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Cursos", mappedBy="informe")
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $cursos;

    /**
     * @var array $productividades
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Productividad", mappedBy="informe")
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $productividades;

    /**
     * @var array $estudiantes
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Estudiantes", mappedBy="informe")
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $estudiantes;

    /**
     * @var array $posdocs
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Posdoc", mappedBy="informe")
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $posdocs;

    /**
     * @var array $proyectos
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Proyectos", mappedBy="informe")
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $proyectos;

    /**
     * @var array $eventos
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Eventos", mappedBy="informe")
     * @ORM\OrderBy({"fechaInicio" = "ASC"})
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $eventos;

    /**
     * @var array $otros
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Otros", mappedBy="informe")
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $otros;

    /**
     * @var array $tecnicos
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Tecnico", mappedBy="informe")
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $tecnicos;

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
     * Set academico
     *
     * @param string $academico
     * @return Informe
     */
    public function setAcademico($academico)
    {
        $this->academico = $academico;

        return $this;
    }

    /**
     * Get academico
     *
     * @return string
     */
    public function getAcademico()
    {
        return $this->academico;
    }

    /**
     * Set dictamen
     *
     * @param string $dictamen
     * @return Informe
     */
    public function setDictamen($dictamen)
    {
        $this->dictamen = $dictamen;

        return $this;
    }

    /**
     * Get dictamen
     *
     * @return string
     */
    public function getDictamen()
    {
        return $this->dictamen;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Informe
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set anio
     *
     * @param string $anio
     * @return Informe
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
     * Add cursos
     *
     * @param \App\Entity\Cursos $cursos
     * @return Academico
     */
    public function addCurso(\App\Entity\Cursos $cursos)
    {
        $this->cursos[] = $cursos;

        return $this;
    }

    /**
     * Remove cursos
     *
     * @param \App\Entity\Cursos $cursos
     */
    public function removeCurso(\App\Entity\Cursos $cursos)
    {
        $this->cursos->removeElement($cursos);
    }

    /**
     * Get cursos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCursos()
    {
        return $this->cursos;
    }

    /**
     * @return mixed
     */
    public function getAprobado()
    {
        return $this->aprobado;
    }

    /**
     * @param mixed $aprobado
     */
    public function setAprobado($aprobado)
    {
        $this->aprobado = $aprobado;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productividades = new \Doctrine\Common\Collections\ArrayCollection();

    }

    /**
     * Get productividades
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductividades()
    {
        return $this->productividades;
    }

    /**
     * Add productividades
     *
     * @param \App\Entity\Productividad $productividades
     * @return Academico
     */
    public function addProductividade(\App\Entity\Productividad $productividades)
    {
        $this->productividades[] = $productividades;

        return $this;
    }

    /**
     * Remove productividades
     *
     * @param \App\Entity\Productividad $productividades
     */
    public function removeProductividade(\App\Entity\Productividad $productividades)
    {
        $this->productividades->removeElement($productividades);
    }

    /**
     * Add estudiantes
     *
     * @param \App\Entity\Estudiantes $estudiantes
     * @return Academico
     */
    public function addEstudiante(\App\Entity\Estudiantes $estudiantes)
    {
        $this->estudiantes[] = $estudiantes;

        return $this;
    }

    /**
     * Remove estudiantes
     *
     * @param \App\Entity\Estudiantes $estudiantes
     */
    public function removeEstudiante(\App\Entity\Estudiantes $estudiantes)
    {
        $this->estudiantes->removeElement($estudiantes);
    }

    /**
     * Get estudiantes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstudiantes()
    {
        return $this->estudiantes;
    }

    /**
     * Add proyectos
     *
     * @param \App\Entity\Proyectos $proyectos
     * @return Academico
     */
    public function addProyecto(\App\Entity\Proyectos $proyectos)
    {
        $this->proyectos[] = $proyectos;

        return $this;
    }

    /**
     * Remove proyectos
     *
     * @param \App\Entity\Proyectos $proyectos
     */
    public function removeProyecto(\App\Entity\Proyectos $proyectos)
    {
        $this->proyectos->removeElement($proyectos);
    }

    /**
     * Get proyectos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProyectos()
    {
        return $this->proyectos;
    }

//    /**
//     * Add eventos
//     *
//     * @param \App\Entity\Eventos $eventos
//     * @return Academico
//     */
//    public function addEvento(\App\Entity\Eventos $eventos)
//    {
//        $this->eventos[] = $eventos;
//
//        return $this;
//    }
//
//    /**
//     * Remove eventos
//     *
//     * @param \App\Entity\Eventos $eventos
//     */
//    public function removeEvento(\App\Entity\Eventos $eventos)
//    {
//        $this->eventos->removeElement($eventos);
//    }
//
//    /**
//     * Get eventos
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getEventos()
//    {
//        return $this->eventos;
//    }
//
    /**
     * Add eventos
     *
     * @param \App\Entity\Eventos $eventos
     * @return Academico
     */
    public function addEvento(\App\Entity\Eventos $eventos)
    {
        $this->eventos[] = $eventos;

        return $this;
    }

    /**
     * Remove eventos
     *
     * @param \App\Entity\Eventos $eventos
     */
    public function removeEvento(\App\Entity\Eventos $eventos)
    {
        $this->eventos->removeElement($eventos);
    }

    /**
     * Get eventos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventos()
    {
        return $this->eventos;
    }

    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * Add otros
     *
     * @param \App\Entity\Otros $otros
     * @return Academico
     */
    public function addOtro(\App\Entity\Otros $otros)
    {
        $this->otros[] = $otros;

        return $this;
    }

    /**
     * Remove otros
     *
     * @param \App\Entity\Otros $otros
     */
    public function removeOtros(\App\Entity\Otros $otros)
    {
        $this->estudiantes->removeElement($otros);
    }

    /**
     * Get otros
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOtros()
    {
        return $this->otros;
    }


    /**
     * Add posdocs
     *
     * @param \App\Entity\Posdoc $posdocs
     * @return Academico
     */
    public function addPosdoc(\App\Entity\Posdoc $posdocs)
    {
        $this->posdocs[] = $posdocs;

        return $this;
    }

    /**
     * Remove posdocs
     *
     * @param \App\Entity\Posdoc $posdocs
     */
    public function removePosdoc(\App\Entity\Posdoc $posdocs)
    {
        $this->posdocs->removeElement($posdocs);
    }

    /**
     * Get posdocs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosdocs()
    {
        return $this->posdocs;
    }

    /**
     * Add tecnicos
     *
     * @param \App\Entity\Tecnico $tecnicos
     * @return Academico
     */
    public function addTecnico(\App\Entity\Tecnico $tecnicos)
    {
        $this->tecnicos[] = $tecnicos;

        return $this;
    }

    /**
     * Remove tecnicos
     *
     * @param \App\Entity\Tecnico $tecnicos
     */
    public function removeTecnico(\App\Entity\Tecnico $tecnicos)
    {
        $this->tecnicos->removeElement($tecnicos);
    }

    /**
     * Get tecnicos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTecnicos()
    {
        return $this->tecnicos;
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