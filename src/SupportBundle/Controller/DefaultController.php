<?php

namespace SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use UserBundle\Entity\User;
use UserBundle\Entity\UserRepository;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tickets = $em->getRepository('SupportBundle:Ticket')->findLast(5);

        return $this->render('SupportBundle:Default:index.html.twig', array('tickets' => $tickets));
    }

    /**
     * @Route("/load")
     */
    public function loadAction()
    {
    	$status = "KO";

    	$username = 'user';
    	$password = 'user';
    	$email = 'user@gfi.fr';
    	$enabled = 1;
    	$isSuperAdmin = 0;

    	$em = $this->getDoctrine()->getManager();
        $user = $this->get('fos_user.util.user_manipulator')->create($username, $password, $email, $enabled, $isSuperAdmin);
        $status = "OK";
        
        return $this->render('SupportBundle:Default:load.html.twig', array('status' => $status));
    }
}
