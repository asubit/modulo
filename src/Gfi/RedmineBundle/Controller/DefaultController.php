<?php

namespace Gfi\RedmineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
	protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

	/*
	 * INIT - Initialisation du Client Redmine
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

	/*
	 * CRITICITÉ - Retourne l'identifiant Redmine de la criticité avec son nom
	 */
	public function getPriorityIdByName($priority_name)
	{
		$priorities = array(
			$this->container->getParameter('redmine_priority_id_mineur') => 'Mineur',
			$this->container->getParameter('redmine_priority_id_majeur') => 'Majeur',
			$this->container->getParameter('redmine_priority_id_bloquant') => 'Bloquant'
		);

		if ($priority_name) {
			$priority_id = array_search($priority_name, $priorities);
		} else {
			$priority_id = null;
		}

		return $priority_id;
	}

	/*
	 * TICKET - Liste les tickets par projet
	 */
    public function listIssuesAction($project_id, $limit = 100)
    {
    	if ($project_id) {
    		$result = $this->init()->api('issue')->all(array(
			    'limit' => $limit,
			    'project_id' => $project_id,
			));
    	} else {
    		$result = null;
    	}
		
    	return $result;
    }

	/*
	 * TICKET - Créer un ticket
	 */
    public function createIssueAction($priority_name, $subject = null, $description = null)
    {
    	$redmineUserAssigneId = $this->container->getParameter('redmine_assigne_user_id');
    	$redmineProjectId = $this->container->getParameter('redmine_project_id');
    	
    	$priority = $this->getPriorityIdByName($priority_name);

    	$result = $this->init()->api('issue')->create(array(
			'project_id' => $redmineProjectId,
			'priority' => $priority,
			'subject' => $subject,
			'description' => $description,
			'assigned_to_id' => $redmineUserAssigneId,
		));

    	return new Response($result->id);
    }

    /*
     * TICKET - Get
     */
    public function getAction($issue_id, $property, $is_sub = 0)
    {
        if ($issue_id) {
            $result = $this->init()->api('issue')->show($issue_id);

            if ($is_sub==1) {
                $result = $result['issue'][$property]['name'];
            } else {
                $result = $result['issue'][$property];
            }
        } else {
            $result = null;
        }

        return new Response($result);
    }

    /*
     * TICKET - Affiche un ticket
     */
    public function showIssueAction($issue_id)
    {
        if ($issue_id) {
            $result = $this->init()->api('issue')->show($issue_id);
        } else {
            $result = null;
        }
        /*var_dump($result);
        $response = new Response();
        ob_start();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');
        $response->setContent($result);*/
        $response =  new JsonResponse($result);

    	return $response;
    }

	/*
	 * TICKET - Supprime un ticket
	 */
    public function deleteIssueAction($issue_id)
    {
    	if ($issue_id) {
    		$result = $this->init()->api('issue')->remove($issue_id);
    	} else {
    		$result = null;
    	}

    	return new Response($result);
    }

	/*
	 * PROJET - Liste les projets
	 */
    public function listProjectAction($limit = 10)
    {
    	//$result = $client->api('project')->listing();
    	$result = $this->init()->api('project')->all(array(
		    'limit' => $limit,
		));

    	return $result;
    }
}
