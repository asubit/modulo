<?php

namespace Gfi\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

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

    /**
     * @var string
     *
     * @ORM\Column(name="civility", type="string", length=255, nullable=true)
     */
    private $civility;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=253, nullable=true)
     */
    private $website;

     /**
     * @var string
     *
     * @ORM\Column(name="tnt_account", type="string", length=8)
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Le numéro de compte TNT doit être de 8 caractères",
     * )
     * @Assert\Regex(
     *     pattern = "/^0[0-9]/", 
     *     message="Format du N° de compte invalide"
     * )
     */
    private $tntAccount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_valid", type="boolean", nullable=true)
     */
    private $isValid;

    public function __construct()
    {
        parent::__construct();
        $this->tickets = new ArrayCollection();
    }

    /**
     * Set isVIP
     *
     * @param boolean $isVIP
     * @return User
     */
    public function setIsVIP($isVIP)
    {
        $this->isVIP = $isVIP;

        return $this;
    }

    /**
     * Get isVIP
     *
     * @return boolean 
     */
    public function getIsVIP()
    {
        return $this->isVIP;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return User
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return User
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Add tickets
     *
     * @param \Gfi\SupportBundle\Entity\Ticket $tickets
     * @return User
     */
    public function addTicket(\Gfi\SupportBundle\Entity\Ticket $tickets)
    {
        $this->tickets[] = $tickets;

        return $this;
    }

    /**
     * Remove tickets
     *
     * @param \Gfi\SupportBundle\Entity\Ticket $tickets
     */
    public function removeTicket(\Gfi\SupportBundle\Entity\Ticket $tickets)
    {
        $this->tickets->removeElement($tickets);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set tntAccount
     *
     * @param string $tntAccount
     * @return User
     */
    public function setTntAccount($tntAccount)
    {
        $this->tntAccount = $tntAccount;

        return $this;
    }

    /**
     * Get tntAccount
     *
     * @return string 
     */
    public function getTntAccount()
    {
        return $this->tntAccount;
    }

    /**
     * Set isValid
     *
     * @param boolean $isValid
     * @return User
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
     * Get isValid
     *
     * @return boolean 
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * Set civility
     *
     * @param string $civility
     * @return User
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * Get civility
     *
     * @return string
     */
    public function getCivility()
    {
        return $this->civility;
    }
}
