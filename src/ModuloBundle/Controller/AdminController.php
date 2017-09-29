<?php

namespace ModuloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AdminController extends Controller
{

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

    /**
     * Generate admin menu
     * @param string $position
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function menuAdminAction($position = 'top')
    {
        // Render admin menu block
        return $this->render('ModuloBundle:Default:menu-admin.html.twig', array(
            'position' => $position
        ));
    }
}