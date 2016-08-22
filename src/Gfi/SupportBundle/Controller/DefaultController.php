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
        $user = $this->getUser();

        // parameters.yml
        $nbLastTickets = $this->container->getParameter('dashboard_nb_last_tickets');
        // findLast($limit = 5) par défaut
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $tickets = $em->getRepository('GfiSupportBundle:Ticket')->findLast($nbLastTickets);
        } else {
            $tickets = $em->getRepository('GfiSupportBundle:Ticket')->findLastbyUser($nbLastTickets, $user);
        }

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
