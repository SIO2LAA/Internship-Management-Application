<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"etu"="Etudiant", "prof"="Professeur"})
 */
class Utilisateur
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
    private $nom;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;
    
    /**
     * @ORM\OneToOne(targetEntity=UserLogin::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $login;
    
    
    public function getId(): ?int
    {
        return $this->id;
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
    
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }
    
    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        
        return $this;
    }
    
    public function getMail(): ?string
    {
        return $this->mail;
    }
    
    public function setMail(string $mail): self
    {
        $this->mail = $mail;
        
        return $this;
    }
    
    public function getType(): ?string
    {
        return $this->type;
    }
    
    public function setType(string $type): self
    {
        $this->type = $type;
        
        return $this;
    }
    
    public function getLogin(): ?UserLogin {
        
        return $this->login;
    }
    
    public function setLogin(UserLogin $login): ?self {
        
        $this->login = $login;
        
        return $this;
    }
}
