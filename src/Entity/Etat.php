<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatRepository::class)
 */
class Etat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;
    
    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="etat")
     */
    private $stages;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function __toString() {
        return '';
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
            $stage->setEtat($this);
        }
        
        return $this;
    }
    
    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEtat() === $this) {
                $stage->setEtat(null);
            }
        }
        
        return $this;
    }
    

}
