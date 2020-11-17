<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;


/**
 * Productividad
 *
 * @ORM\Table(name="productividad")
 * @ORM\Entity(repositoryClass="App\Repository\ProductividadRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Productividad
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
     * @ORM\ManyToOne(targetEntity="Informe", inversedBy="productividades")
     * @ORM\JoinColumn(name="informe_id", referencedColumnName="id")
     */
    private $informe;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=120)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="autores", type="string", length=255, nullable=true)
     */
    private $autores;

    /**
     * @var string
     *
     * @ORM\Column(name="year", type="string", length=255)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="pags", type="string", length=255, nullable=true)
     */
    private $pags;

    /**
     * @var string
     *
     * @ORM\Column(name="volumen", type="string", length=255, nullable=true)
     */
    private $volumen;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255, nullable=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="issn", type="string", length=255, nullable=true)
     */
    private $issn;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectos", type="string", length=255, nullable=true)
     */
    private $proyectos;

    /**
     * @var bool
     *
     * @ORM\Column(name="indizado", type="boolean", nullable=true)
     */
    private $indizado;

    /**
     * @var string
     *
     * @ORM\Column(name="revista", type="string", length=255,nullable=true)
     */
    private $revista;

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
     * @return Productividad
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
     * Set titulo
     *
     * @param string $titulo
     * @return Productividad
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set autores
     *
     * @param string $autores
     * @return Productividad
     */
    public function setAutores($autores)
    {
        $this->autores = $autores;

        return $this;
    }

    /**
     * Get autores
     *
     * @return string
     */
    public function getAutores()
    {
        return $this->autores;
    }

    /**
     * Set year
     *
     * @param string $year
     * @return Productividad
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set pags
     *
     * @param string $pags
     * @return Productividad
     */
    public function setPags($pags)
    {
        $this->pags = $pags;

        return $this;
    }

    /**
     * Get pags
     *
     * @return string
     */
    public function getPags()
    {
        return $this->pags;
    }

    /**
     * Set volumen
     *
     * @param string $volumen
     * @return Productividad
     */
    public function setVolumen($volumen)
    {
        $this->volumen = $volumen;

        return $this;
    }

    /**
     * Get volumen
     *
     * @return string
     */
    public function getVolumen()
    {
        return $this->volumen;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return Productividad
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Productividad
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set issn
     *
     * @param string $issn
     * @return Productividad
     */
    public function setIssn($issn)
    {
        $this->issn = $issn;

        return $this;
    }

    /**
     * Get issn
     *
     * @return string
     */
    public function getIssn()
    {
        return $this->issn;
    }

    /**
     * Set proyectos
     *
     * @param string $proyectos
     * @return Productividad
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
     * Set indizado
     *
     * @param boolean $indizado
     * @return Productividad
     */
    public function setIndizado($indizado)
    {
        $this->indizado = $indizado;

        return $this;
    }

    /**
     * Get indizado
     *
     * @return boolean
     */
    public function getIndizado()
    {
        return $this->indizado;
    }

    /**
     * Set revista
     *
     * @param string $revista
     * @return Productividad
     */
    public function setRevista($revista)
    {
        $this->revista = $revista;

        return $this;
    }

    /**
     * Get revista
     *
     * @return string
     */
    public function getRevista()
    {
        return $this->revista;
    }

    /**
     * Set informe
     *
     * @param \App\Entity\Informe $informe
     * @return Productividad
     */
    public function setInforme(\App\Entity\Informe $informe )
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