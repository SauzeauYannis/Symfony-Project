<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccesController extends AbstractController
{
    protected $em;
    protected $panierRepository;
    protected $produitRepository;
    protected $utilisateurRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->panierRepository = $this->em->getRepository('App:Panier');
        $this->produitRepository = $em->getRepository('App:Produit');
        $this->utilisateurRepository = $em->getRepository('App:Utilisateur');
    }

    public function getUtilisateur(): ?Utilisateur
    {
        $utilisateurId = $this->getParameter('id');

        return $this->utilisateurRepository->find($utilisateurId);
    }

    public function restreindreVisiteur()
    {
        if ($this->getUtilisateur() != null)
            throw $this->createNotFoundException('Vous devez être non authentifié pour accéder à cette page');
    }

    public function restreindreClient()
    {
        if ($this->getUtilisateur() == null || $this->getUtilisateur()->getIsadmin() == 1)
            throw $this->createNotFoundException('Vous devez être client pour accéder à cette page');
    }

    public function restreindreAdministrateur()
    {
        if ($this->getUtilisateur() == null || $this->getUtilisateur()->getIsadmin() != 1)
            throw $this->createNotFoundException('Vous devez être administrateur pour accéder à cette page');
    }

    public function restreindreClientEtAdministrateur()
    {
        if ($this->getUtilisateur() == null)
            throw $this->createNotFoundException('Vous devez être authentifié pour accéder à cette page');
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */