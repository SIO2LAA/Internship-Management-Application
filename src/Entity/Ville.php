<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\ErrorHandler\Collecting;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VilleRepository")
 */
class Ville
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;/**/

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomVille;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numDepartement;

    /**
     * @ORM\OneToMany(targetEntity=Etudiant::class, mappedBy="ville")
     */
    private $etudiants;
    
    /**
     * @ORM\OneToMany(targetEntity=Entreprise::class, mappedBy="ville")
     */
    private $entreprises;

    public function __construct( string $codePostal=null, string $nomVille=null,string $numDepartement=null, int $id=null){
        $this->id=$id;
        $this->nomVille=$nomVille;
        $this->codePostal=$codePostal;
        $this->numDepartement=$numDepartement;
        $this->etudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVille(): ?string
    {
        return $this->nomVille;
    }

    public function setNomVille(string $nomVille): self
    {
        $this->nomVille = $nomVille;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }
    
    public function getNumDepartement(): ?string
    {
        return $this->numDepartement;
    }
    
    public function setNumDepartement(string $numDepartement): self
    {
        $this->numDepartement = $numDepartement;
        
        return $this;
    }

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
            $etudiant->setVille($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getVille() === $this) {
                $etudiant->setVille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Entreprise[]
     */
    public function getEntreprises(): Collection
    {
        return $this->entreprises;
    }

    public function addEntreprise(Entreprise $entreprise): self
    {
        if (!$this->entreprise->contains($entreprise)) {
            $this->entreprises[] = $entreprise;
            $entreprise->setVille($this);
        }

        return $this;
    }

    public function removeEntreprise(Entreprise $entreprise): self
    {
        if ($this->entreprises->removeElement($entreprise)) {
            // set the owning side to null (unless already changed)
            if ($entreprise->getVille() === $this) {
                $entreprise->setVille(null);
            }
        }

        return $this;
    }

    public function setId(int $id) {
        $this->id = $id;

        return $this;
    }

}
