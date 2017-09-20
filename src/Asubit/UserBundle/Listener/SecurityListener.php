<?php

namespace Asubit\UserBundle\Listener;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Asubit\UserBundle\Entity\User;
use Asubit\UserBundle\Entity\UserRepository;

class SecurityListener
{

   public function __construct(SecurityContextInterface $security, Session $session)
   {
      $this->security = $security;
      $this->session = $session;
   }

   public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
   {
      if ($event->getAuthenticationToken()->getUser()->isEnabled() != 1) {
        $this->security->setToken(null);
        $this->session->invalidate();
        $this->session->getFlashBag()->add('info', "Bienvenue!");
        $response = new RedirectResponse('/logout');
        $response->send();
      }
   }

}