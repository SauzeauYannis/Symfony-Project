<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PanierController
 * @package App\Controller
 *
 * @Route("/panier")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier")
     */
    public function panierAction(): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');
        $panierRepository = $em->getRepository('App:Panier');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        if ($utilisateur == null || $utilisateur->getIsadmin() == 1)
            throw $this->createNotFoundException('Vous devez être client pour accéder à cette page');

        $panierUtilisateur = $panierRepository->findBy(['utilisateur' => $utilisateur]);

        $produitsUtilisateur = [];
        $quantiteTotal = 0;
        $prixTotal = 0;

        foreach ($panierUtilisateur as $panierLigne) {
            $produit = $panierLigne->getProduit();
            $produit->setQuantite($panierLigne->getNbAchete());
            $produitsUtilisateur[] = $produit;
            $quantiteTotal += $produit->getQuantite();
            $prixTotal += $produit->getPrixUnitaire() * $produit->getQuantite();
        }

        $args = [
            'produits' => $produitsUtilisateur,
            'quantiteTotal' => $quantiteTotal,
            'prixTotal' => $prixTotal,
        ];
        return $this->render('panier/panier.html.twig', $args);
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */