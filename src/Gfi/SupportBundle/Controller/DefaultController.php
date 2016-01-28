<?php

namespace Gfi\SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Gfi\UserBundle\Entity\User;
use Gfi\UserBundle\Entity\UserRepository;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tickets = $em->getRepository('GfiSupportBundle:Ticket')->findLast(5);

        return array('tickets' => $tickets);
    }

    /**
     * @Route("/load")
     * @Template()
     */
    public function loadAction()
    {
    	$status = "KO";

    	$username = 'user';
    	$password = 'user';
    	$email    = 'user@gfi.fr';
    	$enabled  = 1;
    	$isSuperAdmin = 0;

    	$em = $this->getDoctrine()->getManager();
        $user = $this->get('fos_user.util.user_manipulator')->create($username, $password, $email, $enabled, $isSuperAdmin);
        $status = "OK";
        
        return array('status' => $status);
    }
}
