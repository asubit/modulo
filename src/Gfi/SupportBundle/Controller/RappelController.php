<?php

namespace Gfi\SupportBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Gfi\SupportBundle\Entity\Rappel;
use Gfi\SupportBundle\Form\RappelType;
use Gfi\SupportBundle\Entity\Ticket;
use Gfi\SupportBundle\Form\TicketType;

/**
 * Rappel controller.
 *
 * @Route("/rappel")
 */
class RappelController extends Controller
{
    /**
     * Lists all Rappel entities.
     *
     * @Route("/", name="rappel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if (!$this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('index'));
        }

        $em = $this->getDoctrine()->getManager();

        $rappels = $em->getRepository('GfiSupportBundle:Rappel')->findAll();

        return $this->render('rappel/index.html.twig', array(
            'rappels' => $rappels,
        ));
    }

    /**
     * Creates a new Rappel entity.
     *
     * @Route("/ajout", name="rappel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rappel = new Rappel();

        $form = $this->createForm('Gfi\SupportBundle\Form\RappelType', $rappel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ticket = $form->get('ticket')->getData();
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

            $rappel->setTicket($ticket);
            $em->persist($rappel);

            $ticket->setRappel($rappel);
            $em->persist($ticket);

            $em->flush();

            return $this->redirectToRoute('ticket_show', array('id' => $rappel->getTicket()->getId()));
        }

        return $this->render('rappel/new.html.twig', array(
            'rappel' => $rappel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Rappel entity.
     *
     * @Route("/{id}", name="rappel_show")
     * @Method("GET")
     */
    public function showAction(Rappel $rappel)
    {
        $deleteForm = $this->createDeleteForm($rappel);

        return $this->render('rappel/show.html.twig', array(
            'rappel' => $rappel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Rappel entity.
     *
     * @Route("/{id}/edit", name="rappel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rappel $rappel)
    {
        $deleteForm = $this->createDeleteForm($rappel);
        $editForm = $this->createForm('Gfi\SupportBundle\Form\RappelType', $rappel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rappel);
            $em->flush();

            return $this->redirectToRoute('rappel_edit', array('id' => $rappel->getId()));
        }

        return $this->render('rappel/edit.html.twig', array(
            'rappel' => $rappel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Rappel entity.
     *
     * @Route("/{id}", name="rappel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rappel $rappel)
    {
        $form = $this->createDeleteForm($rappel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rappel);
            $em->flush();
        }

        return $this->redirectToRoute('rappel_index');
    }

    /**
     * Creates a form to delete a Rappel entity.
     *
     * @param Rappel $rappel The Rappel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rappel $rappel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rappel_delete', array('id' => $rappel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
