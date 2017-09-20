<?php

namespace ModuloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transformer
 *
 * @ORM\Table(name="transformer")
 * @ORM\Entity(repositoryClass="ModuloBundle\Repository\TransformerRepository")
 */
class Transformer
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=10)
     */
    private $zipCode;

    /**
     * @ORM\ManyToMany(targetEntity="ModuloBundle\Entity\Service", cascade={"persist"})
     */
    private $services;

    public function __construct()
    {
        $this->services = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Transformer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     * @return Transformer
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string 
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Add services
     *
     * @param \ModuloBundle\Entity\Service $services
     * @return Transformer
     */
    public function addService(\ModuloBundle\Entity\Service $services)
    {
        $this->services[] = $services;

        return $this;
    }

    /**
     * Remove services
     *
     * @param \ModuloBundle\Entity\Service $services
     */
    public function removeService(\ModuloBundle\Entity\Service $services)
    {
        $this->services->removeElement($services);
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getServices()
    {
        return $this->services;
    }
}
