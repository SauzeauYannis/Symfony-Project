<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Table(name="im2021_utilisateurs", options={"comment":"Table des utilisateurs du site"})
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="pk")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, options={"comment"="sert de login (doit être unique)"})
     * @Assert\Length(min = 4, minMessage = "Votre identifiant doit contenir au moins 4 caractères")
     */
    private $identifiant;

    /**
     * @ORM\Column(type="string", length=64, options={"comment"="mot de passe crypté : il faut une taille assez grande pour ne pas le tronquer"})
     * @Assert\Length(min = 4, minMessage = "Votre mot de passe doit contenir au moins 4 caractères")
     */
    private $motdepasse;

    /**
     * @ORM\Column(type="string", length=30, nullable=true, options={"default"=null})
     * @Assert\Length(min = 3, minMessage = "Veuillez entrer au moins 3 caractères")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30, nullable=true, options={"default"=null})*
     * @Assert\Length(min = 3, minMessage = "Veuillez entrer au moins 3 caractères")
     */
    private $prenom;

    /**
     * @ORM\Column(type="date", nullable=true, options={"default"=null})
     */
    private $anniversaire;

    /**
     * @ORM\Column(type="smallint", options={"default"=0, "comment"="type booléen"})
     */
    private $isadmin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): self
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): self
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAnniversaire(): ?\DateTimeInterface
    {
        return $this->anniversaire;
    }

    public function setAnniversaire(?\DateTimeInterface $anniversaire): self
    {
        $this->anniversaire = $anniversaire;

        return $this;
    }

    public function getIsadmin(): ?int
    {
        return $this->isadmin;
    }

    public function setIsadmin(int $isadmin): self
    {
        $this->isadmin = $isadmin;

        return $this;
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */