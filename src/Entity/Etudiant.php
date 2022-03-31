<?php

namespace App\Entity;

use App\Entity\Ville;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtudiantRepository")
 */
class Etudiant extends Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "L'adresse est trop courte",
     *      maxMessage = "L'adresse est trop longue"
     *)
     * Regex a faire : Tout autrisé sauf les caractères spéciaux (Eviter les injections de code)
     * @Assert\Regex(
     *     pattern="/^.*$/i",
     *     match=true,
     *     message="Bien tenté..."
     * )
     */
    private $adresse;
    
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "L'adresse est trop courte",
     *      maxMessage = "L'adresse est trop longue"
     *)
     * Regex a faire : Tout autrisé sauf les caractères spéciaux (Eviter les injections de code)
     * @Assert\Regex(
     *     pattern="/^.*$/i",
     *     match=true,
     *     message="Bien tenté..."
     * )
     */
    private $complementAdresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 14,
     *      max = 14,
     *      minMessage = "Le numéro de téléphone n'est pas de bonnes longeur",
     *)
     * Regex a faire : Tout autrisé sauf les caractères spéciaux (Eviter les injections de code)
     * @Assert\Regex(
     *     pattern="/^.*$/i",
     *     match=true,
     *     message="Bien tenté..."
     * )
     */
    private $telephone;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\ManyToOne(targetEntity=Promotion::class, inversedBy="etudiants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $promotion;

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class, inversedBy="etudiants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="etudiant")
     */
    private $stages;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="etudiants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $specialite;


    public function getIdEtudiant(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
    
    public function getComplementAdresse(): ?string
    {
        return $this->complementAdresse;
    }
    
    public function setComplementAdresse(?string $complementAdresse): self
    {
        $this->complementAdresse = $complementAdresse;
        
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }
    
    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }
    
    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }
    
    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEtudiant($this);
        }
        
        return $this;
    }
    
    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEtudiant() === $this) {
                $stage->setEtudiant(null);
            }
        }
        
        return $this;
    }

    public function getSpecialite(): ?Profil
    {
        return $this->specialite;
    }

    public function setSpecialite(?Profil $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }
    
}
