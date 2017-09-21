<?php

namespace ModuloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuLink
 *
 * @ORM\Table(name="modulo_menu_link")
 * @ORM\Entity(repositoryClass="ModuloBundle\Repository\MenuLinkRepository")
 */
class MenuLink
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
     * @ORM\Column(name="target", type="string", length=2000, nullable=true)
     */
    private $target;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=true)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="links")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id")
     */
    private $menu;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="links")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="links")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     */
    private $page;


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
     * Set target
     *
     * @param string $target
     * @return MenuLink
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return string 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return MenuLink
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set menu
     *
     * @param \ModuloBundle\Entity\Menu $menu
     * @return MenuLink
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

    /**
     * Set category
     *
     * @param \ModuloBundle\Entity\Category $category
     * @return MenuLink
     */
    public function setCategory(\ModuloBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \ModuloBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set page
     *
     * @param \ModuloBundle\Entity\Page $page
     * @return MenuLink
     */
    public function setPage(\ModuloBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \ModuloBundle\Entity\Page 
     */
    public function getPage()
    {
        return $this->page;
    }
}
