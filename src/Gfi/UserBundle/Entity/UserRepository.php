<?php

namespace Gfi\UserBundle\Entity;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    /*
     * Récupère un utilisateur par "username"
     */
    public function loadUserByUsername($username)
    {
        $user = $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $user) {
            $message = sprintf(
                'Unable to find an active admin AppBundle:User object identified by "%s".',
                $username
            );
            throw new UsernameNotFoundException($message);
        }

        return $user;
    }

    /*
     * Récupère un utilisateur par "username"
     */
    public function findAllDisabled()
    {
        $qb = $this->createQueryBuilder('u')->where('u.isValid IS NULL AND u.enabled = 1');

        return $qb->getQuery()->getResult();
    }
}