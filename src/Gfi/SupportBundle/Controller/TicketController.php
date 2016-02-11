<?php

namespace Gfi\SupportBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Gfi\SupportBundle\Entity\Ticket;
use Gfi\SupportBundle\Form\TicketType;

/**
 * Ticket controller.
 *
 * @Route("/ticket")
 */
class TicketController extends Controller
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
     * Restitution back-office
     *
     * @Route("/admin/restitution", name="ticket_restitution")
     * @Method("GET")
     */
    public function restitutionAction()
    {
        // app/config/parameters.yml
        $redmineProjectId = $this->container->getParameter('redmine_project_id');
        // API Redmine : Liste des tickets par ID projet
        $ticketsAll = $this->init()->api('issue')->all(array(
            'project_id' => $redmineProjectId,
            'limit' => 10000000,
        ));
        // Nombre total de tickets pour le projet "TNT Support"
        $nbTicketsTotal = $ticketsAll['total_count'][0];
        // RAF total de tous les tickets
        $rafTotal = 0;
        foreach ($ticketsAll as $key => $t) {
           if ($t[0]['custom_fields'][0]['name'] == "RAF") {
               $rafTotal .= $ticketsAll['issues'][22]['custom_fields'][0]['value'];
           }
        }

        //echo'<pre>';var_dump($ticketsAll);echo'</pre>';die;
        //echo'<pre>';var_dump($ticketsAll['issues'][22]['custom_fields'][0]['name']);echo'</pre>';die;
        //echo'<pre>';var_dump($rafTotal);echo'</pre>';die;

        return $this->render('ticket/restitution.html.twig', array(
            'nbTicketsTotal' => $nbTicketsTotal,
            'rafTotal' => $rafTotal,
        ));
    }

    /**
     * Lists all Ticket entities.
     *
     * @Route("/", name="ticket_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        // Tous les tickets créés sur la plateforme
        $tickets = $em->getRepository('GfiSupportBundle:Ticket')->findAll();

        foreach ($tickets as $ticket) {
            // Récupération des données du ticket côté Redmine
            $status = $this->forward('redmine.manager:getAction', array('issue_id' => $ticket->getIssueId(),'property' => 'status','is_sub'=>1));
            $subject = $this->forward('redmine.manager:getAction', array('issue_id' => $ticket->getIssueId(),'property' => 'subject'));
            $description = $this->forward('redmine.manager:getAction', array('issue_id' => $ticket->getIssueId(),'property' => 'description'));
            // Mise à jour du ticket Plateforme avec les données du ticket Redmine
            $ticket->setSujet($subject->getContent())->setDescription($description->getContent())->setStatut($status->getContent());
            // Enregistrement
            $em->persist($ticket);

            $em->flush();
        }
        
        return $this->render('ticket/index.html.twig', array(
            'tickets' => $tickets,
        ));
    }

    /**
     * Creates a new Ticket entity.
     *
     * @Route("/ajout", name="ticket_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ticket = new Ticket();
        $form = $this->createForm('Gfi\SupportBundle\Form\TicketType', $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Gestion du fichier joint
            $file = $ticket->getFichier();
            if ($file) {
                $fileDate = date('Y'). date('m'). date('d').date('H'). date('i'). date('s').rand(10, 99).'_';// N° unique
                $fileName = $fileDate.$file->getClientOriginalName();// Nom du fichier original
                $fileDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/tickets';// Dossier d'enregistrement
                $file->move($fileDir, $fileName);// Uplaod du fichier
                $ticket->setFichier($fileName);// Enregistrement
            }
            // Gestion des données cachées
            $ticket->setAuteur($this->getUser());// Utilisateur connecté au moment de la création
            $ticket->setStatut('Nouveau');// Par défaut puis géré par RedMine
            $ticket->setDate(new \DateTime());// Date de création

            $newIssue = $this->forward('redmine.manager:createIssueAction', array(
                'priority_name' => $ticket->getCriticite(),
                'subject' => $ticket->getSujet(),
                'description' => $ticket->getDescription()
            ));

            $ticket->setIssueId($newIssue->getContent());
            $ticket->setIsRedmine(true);

            $em->persist($ticket);
            $em->flush();

            return $this->redirectToRoute('ticket_show', array('id' => $ticket->getId()));
        }

        return $this->render('ticket/new.html.twig', array(
            'ticket' => $ticket,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ticket entity.
     *
     * @Route("/{id}", name="ticket_show")
     * @Method("GET")
     */
    public function showAction(Ticket $ticket)
    {
        $em = $this->getDoctrine()->getManager();
        $issue_id = $ticket->getIssueId();
        $redmineHost = $this->container->getParameter('redmine_host');
        $status = $this->forward('redmine.manager:getAction', array('issue_id' => $issue_id,'property' => 'status','is_sub'=>1));
        $subject = $this->forward('redmine.manager:getAction', array('issue_id' => $issue_id,'property' => 'subject'));
        $description = $this->forward('redmine.manager:getAction', array('issue_id' => $issue_id,'property' => 'description'));

        $ticket->setSujet($subject->getContent())->setDescription($description->getContent())->setStatut($status->getContent());
        $em->persist($ticket);
        $em->flush();
        /*echo '<pre>';
        var_dump($status);
        var_dump($subject);
        var_dump($description);
        echo '</pre>';*/

        $deleteForm = $this->createDeleteForm($ticket);

        return $this->render('ticket/show.html.twig', array(
            'ticket' => $ticket,
            'redmineHost' => $redmineHost,
            'delete_form' => $deleteForm->createView(),// RDV 18h30 
        ));
    }

    /**
     * Displays a form to edit an existing Ticket entity.
     *
     * @Route("/{id}/edit", name="ticket_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ticket $ticket)
    {
        $deleteForm = $this->createDeleteForm($ticket);
        $editForm = $this->createForm('Gfi\SupportBundle\Form\TicketType', $ticket);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();

            return $this->redirectToRoute('ticket_edit', array('id' => $ticket->getId()));
        }

        return $this->render('ticket/edit.html.twig', array(
            'ticket' => $ticket,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ticket entity.
     *
     * @Route("/{id}", name="ticket_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ticket $ticket)
    {
        $form = $this->createDeleteForm($ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ticket);
            $em->flush();
        }

        return $this->redirectToRoute('ticket_index');
    }

    /**
     * Creates a form to delete a Ticket entity.
     *
     * @param Ticket $ticket The Ticket entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ticket $ticket)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ticket_delete', array('id' => $ticket->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
