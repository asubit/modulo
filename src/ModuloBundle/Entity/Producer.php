<?php

namespace ModuloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producer
 *
 * @ORM\Table(name="producer")
 * @ORM\Entity(repositoryClass="ModuloBundle\Repository\ProducerRepository")
 */
class Producer
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
     * @ORM\ManyToMany(targetEntity="ModuloBundle\Entity\Product", cascade={"persist"})
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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
     * @return Producer
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
     * @return Producer
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
     * Add products
     *
     * @param \ModuloBundle\Entity\Product $products
     * @return Producer
     */
    public function addProduct(\ModuloBundle\Entity\Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \ModuloBundle\Entity\Product $products
     */
    public function removeProduct(\ModuloBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
}
