<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class AccesController
 * @package App\Controller
 */
class AccesController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var PanierRepository
     */
    protected $panierRepository;
    /**
     * @var ProduitRepository
     */
    protected $produitRepository;
    /**
     * @var UtilisateurRepository
     */
    protected $utilisateurRepository;


    /**
     * AccesController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->panierRepository = $this->em->getRepository('App:Panier');
        $this->produitRepository = $em->getRepository('App:Produit');
        $this->utilisateurRepository = $em->getRepository('App:Utilisateur');
    }

    /**
     * @return Utilisateur|null
     */
    public function getUtilisateur(): ?Utilisateur
    {
        $utilisateurId = $this->getParameter('id');

        return $this->utilisateurRepository->find($utilisateurId);
    }

    /**
     * Rend la page accessible uniquement aux visiteurs
     */
    public function restreindreVisiteur()
    {
        if ($this->getUtilisateur() != null)
            throw $this->createNotFoundException('Vous devez être non authentifié pour accéder à cette page');
    }

    /**
     * Rend la page accessible uniquement aux clients
     */
    public function restreindreClient()
    {
        if ($this->getUtilisateur() == null || $this->getUtilisateur()->getIsadmin() == 1)
            throw $this->createNotFoundException('Vous devez être client pour accéder à cette page');
    }

    /**
     * Rend la page accessible uniquement aux administrateurs
     */
    public function restreindreAdministrateur()
    {
        if ($this->getUtilisateur() == null || $this->getUtilisateur()->getIsadmin() != 1)
            throw $this->createNotFoundException('Vous devez être administrateur pour accéder à cette page');
    }

    /**
     * Rend la page accessible uniquement aux clients et administrateurs
     */
    public function restreindreClientEtAdministrateur()
    {
        if ($this->getUtilisateur() == null)
            throw $this->createNotFoundException('Vous devez être authentifié pour accéder à cette page');
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */
