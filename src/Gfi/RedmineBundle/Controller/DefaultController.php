<?php

namespace Gfi\RedmineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
	protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }
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

	/*
	 * Retourne l'identifiant Redmine de la criticité avec son nom
	 */
	public function getPriorityIdByName($priority_name)
	{
		$priorities = array(
			10 => 'Mineur',
			12 => 'Majeur',
			13 => 'Bloquant'
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
    public function createIssueAction($ticket_id, $priority_name, $subject = null, $description = null)
    {
    	$redmineUserAssigneId = $this->getParameter('redmine_assigne_user_id');
    	$redmineProjectId = $this->getParameter('redmine_project_id');
    	
    	$priority = $this->getPriorityIdByName($priority_name);

    	$result = $this->init()->api('issue')->create(array(
			'cf_2016' => $ticket_id,
			'project_id' => $redmineProjectId,
			'priority' => $priority,
			'subject' => $subject,
			'description' => $description,
			'assigned_to_id' => $redmineUserAssigneId,
		));

    	return $result;
    }

	/*
	 * TICKET - Affiche un ticket
	 */
    public function showIssueAction($issue_id)
    {
    	if ($issue_id) {
    		$result = $this->init()->api('issue')->show($issue_id);
    		/*echo '<pre>';
	        var_dump($result['issue']);
	        echo '</pre>';*/
    	} else {
    		$result = null;
    	}

    	return $result;
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

    public function indexAction()
    {
        
        $result = $this->init()->api('issue')->all(array(
		    'limit' => 100,
		    'project_id' => 101,
		));
        echo'<pre>';
        var_dump($result['issues'][0]);
        //var_dump($result['issues']);
        echo'</pre>';
        return $this->render('GfiRedmineBundle:Default:index.html.twig', array(
        	'result' => $result,
        ));
    }
}
