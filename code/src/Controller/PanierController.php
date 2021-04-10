<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PanierController
 * @package App\Controller
 *
 * @Route("/panier")
 */
class PanierController extends AccesController
{
    /**
     * @Route("/", name="panier_panier")
     */
    public function panierAction(): Response
    {
        $this->restreindreClient();

        $em = $this->getDoctrine()->getManager();
        $panierRepository = $em->getRepository('App:Panier');

        $panierUtilisateur = $panierRepository->findBy(['utilisateur' => $this->getUtilisateur()]);

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

    /**
     * @Route("/supprimer/{produitId}", name="panier_supprimer")
     * @param $produitId
     * @return Response
     */
    public function supprimerAction($produitId): Response
    {
        $this->restreindreClient();

        $em = $this->getDoctrine()->getManager();
        $panierRepository = $em->getRepository('App:Panier');

        $panierProduit = $panierRepository->findOneBy(['utilisateur' => $this->getUtilisateur(), 'produit' => $produitId]);

        $produit = $panierProduit->getProduit();
        $produit->setQuantite($produit->getQuantite() + $panierProduit->getNbAchete());
        $em->remove($panierProduit);

        $em->flush();

        return $this->redirectToRoute('panier_panier');
    }

    /**
     * @Route("/vider", name="panier_vider")
     */
    public function viderAction(): Response
    {
        $this->restreindreClient();

        $em = $this->getDoctrine()->getManager();
        $panierRepository = $em->getRepository('App:Panier');

        $panierUtilisateur = $panierRepository->findBy(['utilisateur' => $this->getUtilisateur()]);

        foreach ($panierUtilisateur as $panierLigne) {
            $produit = $panierLigne->getProduit();
            $produit->setQuantite($produit->getQuantite() + $panierLigne->getNbAchete());
            $em->remove($panierLigne);
        }

        $em->flush();

        return $this->redirectToRoute('panier_panier');
    }

    /**
     * @Route("/acheter", name="panier_acheter")
     */
    public function acheterAction(): Response
    {
        $this->restreindreClient();

        $em = $this->getDoctrine()->getManager();
        $panierRepository = $em->getRepository('App:Panier');

        $panierUtilisateur = $panierRepository->findBy(['utilisateur' => $this->getUtilisateur()]);

        foreach ($panierUtilisateur as $panierLigne)
            $em->remove($panierLigne);

        $em->flush();

        return $this->redirectToRoute('panier_panier');
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */