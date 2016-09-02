<?php

namespace Gfi\SupportBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Gfi\UserBundle\Entity\User;
use Gfi\UserBundle\Entity\UserRepository;
use Gfi\SupportBundle\Entity\Ticket;

class AdminController extends Controller
{
	/*
     * Initialisation du Client Redmine
     */
    public function init()
    {
        $redmineHost = $this->container->getParameter('redmine_host');
        $redmineUser = $this->container->getParameter('redmine_user');
        $redminePswd = $this->container->getParameter('redmine_pswd');
        $redmineUserAssigneId = $this->container->getParameter('redmine_assigne_user_id');

        $client = new \Redmine\Client($redmineHost, $redmineUser, $redminePswd);

        return $client;
    }

    /**
     * @Route("/admin", name="admin_index")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
        // Call API - Liste des tickets par ID projet
        $redmineProjectId = $this->container->getParameter('redmine_project_id');
        $ticketsAll = $this->init()->api('issue')->all(array(
            'project_id' => $redmineProjectId,
            'limit' => 10000000,
        ));
        // Restitution - Nombre de tickets total
        $nbTicketsTotal = $ticketsAll['total_count'][0];
        // Restitution - Reste à faire total
        $rafTotal = 0;
        foreach ($ticketsAll as $key => $t) {
           if ($t[0]['custom_fields'][0]['name'] == "RAF") {
               $rafTotal .= $ticketsAll['issues'][22]['custom_fields'][0]['value'];
           }
        }
        // New users to enbled
        $users = $em->getRepository('GfiUserBundle:User')->findAllDisabled();
        // TODO : Ajouter d'autres résultat. A définir by Gfi...

        return $this->render('admin/index.html.twig', array(
            'nbTicketsTotal' => $nbTicketsTotal,
            'rafTotal'       => $rafTotal,
            'users'          => $users,
        ));
    }

    /**
     * @Route("/admin/user/{id}/activate", name="admin_user_activate")
     * @Template("admin/index.html.twig")
     * @Method({"GET", "POST"})
     */
    public function userActivateAction(Request $request, User $user)
    {
    	$em = $this->getDoctrine()->getManager();
    	$user->setIsValid(true);
    	$em->persist($user);
    	$em->flush();

    	// send mail
    	$message = \Swift_Message::newInstance()
        ->setSubject('Votre compte est validé!')
        ->setFrom('no-reply@support.ecommerce.tnt.fr')
        ->setTo($user->getEmail())
        ->setBody(
            $this->renderView(
                // app/Resources/views/emails/isvalid.html.twig
                'emails/isvalid.html.twig',
                array(
                	'firstname'  => $user->getFirstname(), 
                	'lastname'   => $user->getLastname(), 
                	'tntAccount' => $user->getTntAccount()
                )
            ),
            'text/html'
        )
        ->addPart(
            $this->renderView(
                'emails/isvalid.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        );
    	$this->get('mailer')->send($message);

    	return $this->redirect($this->generateUrl('admin_index'));

    }


}