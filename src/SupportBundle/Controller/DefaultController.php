<?php

namespace SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use UserBundle\Entity\User;
use UserBundle\Entity\UserRepository;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('SupportBundle:Default:index.html.twig');
    }

    /**
     * @Route("/load")
     */
    public function loadAction()
    {
    	$status = "KO";

    	$username = 'admin';
    	$password = 'admin';
    	$email = 'antoine.subit@gfi.fr';
    	$enabled = 1;
    	$isSuperAdmin = 1;

    	$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository("UserBundle:User")->loadUserByUsername($username);

    	if (!$user) {
    		$user = $this->get('fos_user.util.user_manipulator')->create($username, $password, $email, $enabled, $isSuperAdmin);
    		$status = "OK";
    	} else {$status=$status.". admin déjà créé.";}

        return $this->render('SupportBundle:Default:load.html.twig', array('status' => $status));
    }
}
