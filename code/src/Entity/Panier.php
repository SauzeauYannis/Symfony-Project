<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="im2021_panier", options={"comment":"Table du panier du site"})
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(referencedColumnName="pk", nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_achete;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getNbAchete(): ?int
    {
        return $this->nb_achete;
    }

    public function setNbAchete(int $nb_achete): self
    {
        $this->nb_achete = $nb_achete;

        return $this;
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */