<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PromotionRepository")
 */
class Promotion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nom;

    /**
     * @ORM\Column(type="string")
     */
    private $anneeDebut;

    /**
     * @ORM\Column(type="string")
     */
    private $anneeFin;

    /**
     * @ORM\OneToMany(targetEntity=Etudiant::class, mappedBy="promotion")
     */
    private $etudiants;



    public function __construct(String $nom=null, int $anneeDebut=null, int $anneeFin=null){
        $this->nom = $nom;
        $this->anneeDebut = $anneeDebut;
        $this->anneeFin = $anneeFin;
        $this->etudiants = new ArrayCollection();

    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function setId(int $id): self
    {
        $this->id = $id;
        
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAnneeDebut(): ?string
    {
        return $this->anneeDebut;
    }

    public function setAnneeDebut(string $anneeDebut): self
    {
        $this->anneeDebut = $anneeDebut;

        return $this;
    }

    public function getAnneeFin(): ?string
    {
        return $this->anneeFin;
    }

    public function setAnneeFin(string $anneeFin): self
    {
        $this->anneeFin = $anneeFin;
        
        return $this;
    }

    /**/
    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setPromotion($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getPromotion() === $this) {
                $etudiant->setPromotion(null);
            }
        }

        return $this;
    }



}
