<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfessionnelRepository")
 */
class Professionnel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titreProfessionnel;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $nomProfessionnel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenomProfessionnel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $professionProfessionnel;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $telephoneProfessionnel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mailProfessionnel;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="professionnels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entreprise;
    
    public function __construct(string $mailProfessionnel=null,string $telephoneProfessionnel=null,$titreProfessionnel=null,string $professionProfessionnel=null,string $prenomProfessionnel=null,string $nomProfessionnel=null,int $id=null){
        
            $this-> id=$id;
            $this-> titreProfessionnel=$titreProfessionnel;
            $this-> nomProfessionnel=$nomProfessionnel;
            $this-> prenomProfessionnel=$prenomProfessionnel;
            $this-> professionProfessionnel=$professionProfessionnel;
            $this-> telephoneProfessionnel=$telephoneProfessionnel;
            $this-> mailProfessionnel=$mailProfessionnel;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getTitreProfessionnel(): ?string
    {
        return $this->titreProfessionnel;
    }
    
    public function setTitreProfessionnel(string $titreProfessionnel): self
    {
        $this->titreProfessionnel = $titreProfessionnel;
        
        return $this;
    }

    public function getNomProfessionnel(): ?string
    {
        return $this->nomProfessionnel;
    }

    public function setNomProfessionnel(string $nomProfessionnel): self
    {
        $this->nomProfessionnel = $nomProfessionnel;

        return $this;
    }

    public function getPrenomProfessionnel(): ?string
    {
        return $this->prenomProfessionnel;
    }

    public function setPrenomProfessionnel(string $prenomProfessionnel): self
    {
        $this->prenomProfessionnel = $prenomProfessionnel;

        return $this;
    }

    public function getProfessionProfessionnel(): ?string
    {
        return $this->professionProfessionnel;
    }

    public function setProfessionProfessionnel(?string $professionProfessionnel): self
    {
        $this->professionProfessionnel = $professionProfessionnel;

        return $this;
    }

    public function getTelephoneProfessionnel(): ?string
    {
        return $this->telephoneProfessionnel;
    }

    public function setTelephoneProfessionnel(?string $telephoneProfessionnel): self
    {
        $this->telephoneProfessionnel = $telephoneProfessionnel;

        return $this;
    }

    public function getMailProfessionnel(): ?string
    {
        return $this->mailProfessionnel;
    }

    public function setMailProfessionnel(?string $mailProfessionnel): self
    {
        $this->mailProfessionnel = $mailProfessionnel;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

}
