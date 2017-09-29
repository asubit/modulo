<?php

namespace ModuloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use ModuloBundle\Entity\Article;
use ModuloBundle\Entity\Category;
use ModuloBundle\Entity\Page;

/**
 * This controller manage all frontend views and actions
 * Class DefaultController
 * @package ModuloBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render('ModuloBundle:Default:index.html.twig');
    }

    /**
     * Finds and displays a Article entity in frontend.
     *
     * @Route("/article/{id}", name="article_front_view")
     * @Method("GET")
     */
    public function articleFrontViewAction(Article $article)
    {
        return $this->render('article/front-view.html.twig', array(
            'article' => $article,
        ));
    }

    /**
     * Finds and displays a Category entity in frontend.
     *
     * @Route("/category/{id}", name="category_front_view")
     * @Method("GET")
     */
    public function categoryFrontViewAction(Category $category)
    {
        return $this->render('category/front-view.html.twig', array(
            'category' => $category,
        ));
    }

    /**
     * Lists all Category entities in frontend.
     *
     * @Route("/category", name="category_front_list")
     * @Method("GET")
     */
    public function categoryFrontListAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ModuloBundle:Category')->findAll();

        return $this->render('category/front-list.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Finds and displays a Page entity in frontend.
     *
     * @Route("/page/{id}", name="page_front_view")
     * @Method("GET")
     */
    public function pageFrontViewAction(Page $page)
    {
        return $this->render('page/front-view.html.twig', array(
            'page' => $page,
        ));
    }

    /**
     * Generate menu
     * @param string $menu
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function menuAction($menu = 'top')
    {
        $em = $this->getDoctrine()->getManager();
        // Get the menu by position
        $menu = $em->getRepository('ModuloBundle:Menu')
            ->createQueryBuilder('m')
            ->where('m.position = :position')
            ->setParameter('position', $menu)
            ->getQuery()
            ->getOneOrNullResult();
        // Get menu links
        $links = $em->getRepository('ModuloBundle:MenuLink')
            ->createQueryBuilder('ml')
            ->join('ml.menu', 'm')
            ->where('m.position = :position')
            ->setParameter('position', $menu)
            ->getQuery()
            ->getResult();
        // Render menu block
        return $this->render('ModuloBundle:Default:menu.html.twig', array(
            'menu' => $menu,
            'links' => $links,
        ));
    }
}