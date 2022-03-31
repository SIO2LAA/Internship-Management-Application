<?php

namespace App\Entity;

use App\Entity\Ville;
use App\Entity\Profil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\Length(
     *      min = 2,
     *      max = 40,
     *      minMessage = "Le Nom de l'entreprise est trop court. {{ limit }} caractères minimum",
     *)
     * Regex a faire : Tout autrisé sauf les caractères spéciaux (Eviter les injections de code)
     * @Assert\Regex(
     *     pattern="/^.*$/i",
     *     match=true,
     *     message="Bien tenté..."
     * )
     */
    private $nomEntreprise;
    
    /**
     * @ORM\Column(type="string", length=14, nullable=true)
     * 
     * @Assert\Length(
     *      min = 10,
     *      max = 14,
     *      minMessage = "Le numero de telephone est trop court",
     *)
     * Regex a faire : Tout autrisé sauf les caractères spéciaux (Eviter les injections de code)
     * @Assert\Regex(
     *     pattern="/^.*$/i",
     *     match=true,
     *     message="Bien tenté..."
     * )
     */
    private $telephoneEntreprise;
    
    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * 
     * 
     * @Assert\Length(
     *      min = 6,
     *      max = 30,
     *      minMessage = "L'adresse mail est trop courte",
     *      maxMessage = "L'adresse mail est trop longue"
     *)
     * 
     * @Assert\Email(
     *     message = "L'adresse mail : '{{ value }}' n'est pas valide."
     * )
     * Regex a faire : Tout autrisé sauf les caractères spéciaux (Eviter les injections de code)
     * @Assert\Regex(
     *     pattern="/^.*$/i",
     *     match=true,
     *     message="Bien tenté..."
     * )
     */
    private $mailEntreprise;
    
    /**
     * @ORM\Column(type="string", length=50)
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
    private $adresseEntreprise;
    
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     * 
     *  @Assert\Length(
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
    private $complementAdresseEntreprise;
    
    /**
     * @ORM\ManyToOne(targetEntity=Ville::class)
     * @ORM\JoinColumn
     */
    private $ville;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class)
     * @ORM\JoinColumn
     */
    private $specialite;

    /**
     * @ORM\OneToMany(targetEntity=Professionnel::class, mappedBy="entreprise")
     */
    private $professionnels;
    
    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="entreprise")
     */
    private $stages;
    
    public function __construct(Profil $specialite=null,Ville $ville=null,string $adresseEntreprise=null,string $complementAdresseEntreprise=null,string $mailEntreprise=null,string $telephoneEntreprise=null,string $nomEntreprise=null,int $id=null){
        $this->idEntreprise=$id;
        $this->adresseEntreprise=$adresseEntreprise;
        $this->complementAdresseEntreprise=$complementAdresseEntreprise;
        $this->mailEntreprise=$mailEntreprise;
        $this->telephoneEntreprise=$telephoneEntreprise;
        $this->nomEntreprise=$nomEntreprise;
        $this->ville=$ville;
        $this->specialite=$specialite;
        $this->professionnels = new ArrayCollection();
      
        
        
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }
    
    public function setNomEntreprise(string $nomEntreprise): self
    {
        $this->nomEntreprise = $nomEntreprise;
        
        return $this;
    }
    
    public function getTelephoneEntreprise(): ?string
    {
        return $this->telephoneEntreprise;
    }
    
    public function setTelephoneEntreprise(?string $telephoneEntreprise): self
    {
        $this->telephoneEntreprise = $telephoneEntreprise;
        
        return $this;
    }
    
    public function getMailEntreprise(): ?string
    {
        return $this->mailEntreprise;
    }
    
    public function setMailEntreprise(?string $mailEntreprise): self
    {
        $this->mailEntreprise = $mailEntreprise;
        
        return $this;
    }
    
    public function getAdresseEntreprise(): ?string
    {
        return $this->adresseEntreprise;
    }
    
    public function setAdresseEntreprise(string $adresseEntreprise): self
    {
        $this->adresseEntreprise = $adresseEntreprise;
        
        return $this;
    }
    
    public function getComplementAdresseEntreprise(): ?string
    {
        return $this->complementAdresseEntreprise;
    }
    
    public function setComplementAdresseEntreprise(string $complementAdresseEntreprise): self
    {
        $this->complementAdresseEntreprise = $complementAdresseEntreprise;
        
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

    public function getSpecialite(): ?Profil
    {
        return $this->specialite;
    }

    public function setSpecialite(?Profil $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * @return Collection|Professionnel[]
     */
    public function getProfessionnels(): Collection
    {
        return $this->professionnels;
    }

    public function addProfessionnel(Professionnel $professionnel): self
    {
        if (!$this->professionnels->contains($professionnel)) {
            $this->professionnels[] = $professionnel;
            $professionnel->setEntreprise($this);
        }

        return $this;
    }

    public function removeProfessionnel(Professionnel $professionnel): self
    {
        if ($this->professionnels->removeElement($professionnel)) {
            // set the owning side to null (unless already changed)
            if ($professionnel->getEntreprise() === $this) {
                $professionnel->setEntreprise(null);
            }
        }

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
            $stage->setEntreprise($this);
        }
        
        return $this;
    }
    
    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }
        
        return $this;
    }
   
   
}
