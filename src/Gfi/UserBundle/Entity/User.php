<?php

namespace Gfi\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Gfi\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	/**
     * @ORM\OneToMany(targetEntity="Gfi\SupportBundle\Entity\Ticket", mappedBy="auteur")
     */
    protected $tickets;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_vip", type="boolean", nullable=true)
     */
    private $isVIP;

    public function __construct()
    {
        parent::__construct();
        $this->tickets = new ArrayCollection();
    }
}