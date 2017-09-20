<?php

namespace Gfi\UserBundle\Listener;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Gfi\UserBundle\Entity\User;
use Gfi\UserBundle\Entity\UserRepository;

class SecurityListener
{

   public function __construct(SecurityContextInterface $security, Session $session)
   {
      $this->security = $security;
      $this->session = $session;
   }

   public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
   {
      if ($event->getAuthenticationToken()->getUser()->getIsValid() != 1) {
        //var_dump('not valid');die;
        $this->security->setToken(null);
        $this->session->invalidate();
        $this->session->getFlashBag()->add('info', "Bienvenue! Nous sommes en train d'étudier votre dossier afin de valider que votre numéro de compte TNT. Vous recevrez un email quand votre compte sera validé.");
        $response = new RedirectResponse('/logout');
        $response->send();
      }
   }

}