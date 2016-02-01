<?php

namespace Gfi\RedmineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$redmineHost = $this->getParameter('redmine_host');
    	$redmineUser = $this->getParameter('redmine_user');
    	$redminePswd = $this->getParameter('redmine_pswd');
    	$redmineUserAssigneId = $this->getParameter('redmine_assigne_user_id');

        $client = new \Redmine\Client($redmineHost, $redmineUser, $redminePswd);
        //$result = $client->api('project')->listing();
        //$result = $client->api('issue')->all(array('project_id' => 'TNT - Interface saisie tickets'));
        $result = $client->api('issue')->all(array(
		    'limit' => 100,
		    'project_id' => 101,
		));
		//$result = $client->api('issue')->show(1283);
		//$result = $client->api('user')->getIdByUsername('asubit');

		/*$client->api('issue')->create(array(
    'project_id' => 101,
    'subject' => 'test api (xml) 2',
    'description' => 'test api',
    'assigned_to_id' => $redmineUserAssigneId,));*/
        echo'<pre>';
        var_dump($result);
        echo'</pre>';
        return $this->render('GfiRedmineBundle:Default:index.html.twig', array(
        	'result' => $result,
        ));
    }
}
