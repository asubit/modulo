<?php

namespace Gfi\RedmineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GfiRedmineBundle:Default:index.html.twig');
    }
}
