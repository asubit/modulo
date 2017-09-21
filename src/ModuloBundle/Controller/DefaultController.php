<?php

namespace ModuloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {
        return $this->render('ModuloBundle:Default:admin.html.twig');
    }

    /**
     * @Route("/admin/settings", name="settings")
     */
    public function settingsAction()
    {
        return $this->render('ModuloBundle:Default:settings.html.twig');
    }

    public function menuAction($menu = 'top')
    {
        $em = $this->getDoctrine()->getManager();

        $menu = $em->getRepository('ModuloBundle:Menu')
            ->createQueryBuilder('m')
            ->where('m.position = :position')
            ->setParameter('position', $menu)
            ->getQuery()
            ->getOneOrNullResult();

        $links = $em->getRepository('ModuloBundle:MenuLink')
            ->createQueryBuilder('ml')
            ->join('ml.menu', 'm')
            ->where('m.position = :position')
            ->setParameter('position', $menu)
            ->getQuery()
            ->getResult();
        return $this->render('ModuloBundle:Default:menu-top.html.twig', array(
            'menu' => $menu,
            'links' => $links,
        ));
    }
}