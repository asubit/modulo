<?php

namespace ModuloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuWidget
 *
 * @ORM\Table(name="modulo_menu_widget")
 * @ORM\Entity(repositoryClass="ModuloBundle\Repository\MenuWidgetRepository")
 */
class MenuWidget
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="widgets")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id")
     */
    private $menu;


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
     * Set type
     *
     * @param string $type
     * @return MenuWidget
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

    /**
     * Set value
     *
     * @param string $value
     * @return MenuWidget
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set menu
     *
     * @param \ModuloBundle\Entity\Menu $menu
     * @return MenuWidget
     */
    public function setMenu(\ModuloBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \ModuloBundle\Entity\Menu 
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
