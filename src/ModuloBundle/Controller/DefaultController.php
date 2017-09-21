<?php

namespace ModuloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('ModuloBundle:Default:index.html.twig');
    }

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return $this->render('ModuloBundle:Default:admin.html.twig');
    }
}
