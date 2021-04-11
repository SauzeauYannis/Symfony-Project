<?php

namespace App\Controller;

use App\Services\MyService;
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
    public function panierAction(MyService $myService): Response
    {
        $this->restreindreClient();

        $panierUtilisateur = $this->panierRepository->findBy(['utilisateur' => $this->getUtilisateur()]);

        $produitsUtilisateur = [];
        $quantiteTotal = [];
        $prixTotal = [];

        foreach ($panierUtilisateur as $panierLigne)
        {
            $produit = $panierLigne->getProduit();
            $produit->setQuantite($panierLigne->getNbAchete());

            $produitsUtilisateur[] = $produit;
            $quantiteTotal[] = $produit->getQuantite();
            $prixTotal[] = $produit->getPrixUnitaire() * $produit->getQuantite();
        }

        $args = [
            'produits' => $produitsUtilisateur,
            'quantiteTotal' => $myService->tabSum($quantiteTotal),
            'prixTotal' => $myService->tabSum($prixTotal),
        ];

        return $this->render('panier/panier.html.twig', $args);
    }

    /**
     * @Route(
     *     "/supprimer/{produitId}",
     *     name="panier_supprimer",
     *     requirements={"produitId": "[0-9]+"}
     * )
     * @param $produitId
     * @return Response
     */
    public function supprimerAction($produitId): Response
    {
        $this->restreindreClient();

        $panierProduit = $this->panierRepository->findOneBy(['utilisateur' => $this->getUtilisateur(), 'produit' => $produitId]);

        $produit = $panierProduit->getProduit();
        $produit->setQuantite($produit->getQuantite() + $panierProduit->getNbAchete());

        $this->em->remove($panierProduit);
        $this->em->flush();

        return $this->redirectToRoute('panier_panier');
    }

    /**
     * @Route("/vider", name="panier_vider")
     */
    public function viderAction(): Response
    {
        $this->restreindreClient();

        $panierUtilisateur = $this->panierRepository->findBy(['utilisateur' => $this->getUtilisateur()]);

        foreach ($panierUtilisateur as $panierLigne)
        {
            $produit = $panierLigne->getProduit();
            $produit->setQuantite($produit->getQuantite() + $panierLigne->getNbAchete());

            $this->em->remove($panierLigne);
        }

        $this->em->flush();

        return $this->redirectToRoute('panier_panier');
    }

    /**
     * @Route("/acheter", name="panier_acheter")
     */
    public function acheterAction(): Response
    {
        $this->restreindreClient();

        $panierUtilisateur = $this->panierRepository->findBy(['utilisateur' => $this->getUtilisateur()]);

        foreach ($panierUtilisateur as $panierLigne)
            $this->em->remove($panierLigne);

        $this->em->flush();

        return $this->redirectToRoute('panier_panier');
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */