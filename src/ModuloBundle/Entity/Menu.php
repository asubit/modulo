<?php

namespace ModuloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Menu
 *
 * @ORM\Table(name="modulo_menu")
 * @ORM\Entity(repositoryClass="ModuloBundle\Repository\MenuRepository")
 */
class Menu
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255)
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="MenuLink", mappedBy="menu")
     */
    private $links;

    /**
     * @ORM\OneToMany(targetEntity="MenuWidget", mappedBy="menu")
     */
    private $widgets;

    public function __construct()
    {
        $this->links = new ArrayCollection();
        $this->widgets = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Menu
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return Menu
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add links
     *
     * @param \ModuloBundle\Entity\MenuLink $links
     * @return Menu
     */
    public function addLink(\ModuloBundle\Entity\MenuLink $links)
    {
        $this->links[] = $links;

        return $this;
    }

    /**
     * Remove links
     *
     * @param \ModuloBundle\Entity\MenuLink $links
     */
    public function removeLink(\ModuloBundle\Entity\MenuLink $links)
    {
        $this->links->removeElement($links);
    }

    /**
     * Get links
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Add widgets
     *
     * @param \ModuloBundle\Entity\MenuWidget $widgets
     * @return Menu
     */
    public function addWidget(\ModuloBundle\Entity\MenuWidget $widgets)
    {
        $this->widgets[] = $widgets;

        return $this;
    }

    /**
     * Remove widgets
     *
     * @param \ModuloBundle\Entity\MenuWidget $widgets
     */
    public function removeWidget(\ModuloBundle\Entity\MenuWidget $widgets)
    {
        $this->widgets->removeElement($widgets);
    }

    /**
     * Get widgets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWidgets()
    {
        return $this->widgets;
    }
}
