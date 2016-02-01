<?php

namespace Gfi\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="Gfi\SupportBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_redmine", type="boolean", nullable=true)
     */
    private $isRedmine;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Le sujet est obligatoire.")
     * @ORM\Column(name="sujet", type="string", length=255)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="criticite", type="string", length=255, nullable=true)
     */
    private $criticite;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255)
     */
    private $statut;

    /**
     * @var datetime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Gfi\UserBundle\Entity\User", inversedBy="tickets")
     * @ORM\JoinColumn(name="auteur_id", referencedColumnName="id")
     */
    protected $auteur;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\File(
     *     maxSize = "2048k",
     *     maxSizeMessage = "Le poids maximum authorisé est 2M."
     * )
     */
    private $fichier;

    /**
     * @ORM\OneToOne(targetEntity="Rappel", mappedBy="ticket", cascade={"persist"})
     */
    private $rappel;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set isRedmine
     *
     * @param boolean $isRedmine
     * @return Ticket
     */
    public function setIsRedmine($isRedmine)
    {
        $this->isRedmine = $isRedmine;

        return $this;
    }

    /**
     * Get isRedmine
     *
     * @return boolean 
     */
    public function getIsRedmine()
    {
        return $this->isRedmine;
    }

    /**
     * Set sujet
     *
     * @param string $sujet
     * @return Ticket
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string 
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Ticket
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set criticite
     *
     * @param string $criticite
     * @return Ticket
     */
    public function setCriticite($criticite)
    {
        $this->criticite = $criticite;

        return $this;
    }

    /**
     * Get criticite
     *
     * @return string 
     */
    public function getCriticite()
    {
        return $this->criticite;
    }

    /**
     * Set statut
     *
     * @param string $statut
     * @return Ticket
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set date
     *
     * @param datetime $date
     * @return Ticket
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set auteur
     *
     * @param \Gfi\UserBundle\Entity\User $auteur
     * @return Ticket
     */
    public function setAuteur(\Gfi\UserBundle\Entity\User $auteur = null)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \Gfi\UserBundle\Entity\User 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set fichier
     *
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;
    }

    /**
     * Get fichier
     *
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * Set rappel
     *
     * @param \Gfi\SupportBundle\Entity\Rappel $rappel
     * @return Ticket
     */
    public function setRappel(\Gfi\SupportBundle\Entity\Rappel $rappel = null)
    {
        $this->rappel = $rappel;

        return $this;
    }

    /**
     * Get rappel
     *
     * @return \Gfi\SupportBundle\Entity\Rappel 
     */
    public function getRappel()
    {
        return $this->rappel;
    }
}
