<?php

namespace ModuloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="ModuloBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="origin_department", type="string", length=255)
     */
    private $originDepartment;

    /**
     * @var string
     *
     * @ORM\Column(name="origin_country", type="string", length=255)
     */
    private $originCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="temperature", type="string", length=255)
     */
    private $temperature;

    /**
     * @var string
     *
     * @ORM\Column(name="conditioning", type="string", length=255)
     */
    private $conditioning;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;


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
     * @return Product
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
     * Set originDepartment
     *
     * @param string $originDepartment
     * @return Product
     */
    public function setOriginDepartment($originDepartment)
    {
        $this->originDepartment = $originDepartment;

        return $this;
    }

    /**
     * Get originDepartment
     *
     * @return string 
     */
    public function getOriginDepartment()
    {
        return $this->originDepartment;
    }

    /**
     * Set originCountry
     *
     * @param string $originCountry
     * @return Product
     */
    public function setOriginCountry($originCountry)
    {
        $this->originCountry = $originCountry;

        return $this;
    }

    /**
     * Get originCountry
     *
     * @return string 
     */
    public function getOriginCountry()
    {
        return $this->originCountry;
    }

    /**
     * Set temperature
     *
     * @param string $temperature
     * @return Product
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get temperature
     *
     * @return string 
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set conditioning
     *
     * @param string $conditioning
     * @return Product
     */
    public function setConditioning($conditioning)
    {
        $this->conditioning = $conditioning;

        return $this;
    }

    /**
     * Get conditioning
     *
     * @return string 
     */
    public function getConditioning()
    {
        return $this->conditioning;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Product
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
}
