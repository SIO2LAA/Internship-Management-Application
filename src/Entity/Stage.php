<?php

namespace App\Entity;


use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 */
class Stage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idStage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avisEtudiant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $noteEtudiant;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreation;
    
    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;
    
    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity=Etudiant::class, inversedBy="stages")
     */
    private $etudiant;

    /**
     * @ORM\ManyToOne(targetEntity=Professeur::class)
     */
    private $professeur;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class)
     */
    private $entreprise;

    /**
     * @ORM\ManyToOne(targetEntity=Professionnel::class)
     */
    private $tuteur;

    /**
     * @ORM\ManyToOne(targetEntity=Professionnel::class)
     */
    private $signataire;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class)
     * @ORM\JoinColumn(name="etat_id", referencedColumnName="id", nullable=false)
     */
    private $etat;

    public function __construct() {
        $this->etat = new Etat();
    }
    
    public function getIdStage(): ?int {
        return $this->idStage;
    }
    
    public function setIdStage(int $idStage): self {
        $this->idStage = $idStage;
        
        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;

        return $this;
    }

    public function getAvisEtudiant(): ?string {
        return $this->avisEtudiant;
    }

    public function setAvisEtudiant(string $avisEtudiant): self {
        $this->avisEtudiant = $avisEtudiant;

        return $this;
    }

    public function getNoteEtudiant(): ?int {
        return $this->noteEtudiant;
    }

    public function setNoteEtudiant(?int $noteEtudiant): self {
        $this->noteEtudiant = $noteEtudiant;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface {
        return $this->dateDebut;
    }
    
    public function setDateDebut(\DateTimeInterface $dateDebut): self {
        $this->dateDebut = $dateDebut;
        
        return $this;
    }
    
    public function getDateFin(): ?\DateTimeInterface {
        return $this->dateFin;
    }
    
    public function setDateFin(\DateTimeInterface $dateFin): self {
        $this->dateFin = $dateFin;
        
        return $this;
    }
    
    public function getDateCreation(): ?\DateTimeInterface {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self {
        $this->dateCreation = $dateCreation;

        return $this;
    }
    
    public function getEtudiant(): ?Etudiant {
        return $this->etudiant;
    }
    
    public function setEtudiant($etudiant): self {
        $this->etudiant = $etudiant;
        
        return $this;
    }
    
    public function getProfesseur()
    {
        return $this->professeur;
    }
    
    public function getEntreprise()
    {
        return $this->entreprise;
    }
    
    public function getTuteur()
    {
        return $this->tuteur;
    }
    
    public function getSignataire()
    {
        return $this->signataire;
    }
    
    public function getEtat()
    {
        return $this->etat;
    }
    
    public function setProfesseur($professeur)
    {
        $this->professeur = $professeur;
    }
    
    public function setEntreprise($entreprise)
    {
        $this->entreprise = $entreprise;
    }
    
    public function setTuteur($tuteur)
    {
        $this->tuteur = $tuteur;
    }
    
    public function setSignataire($signataire)
    {
        $this->signataire = $signataire;
    }
    
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }
    
}



