<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Services\MyService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectManager;
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

        foreach ($panierUtilisateur as $panierProduit)
        {
            $produit = $panierProduit->getProduit();
            $produit->setQuantite($panierProduit->getNbAchete());

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
     * @throws ORMException
     */
    public function supprimerAction($produitId): Response
    {
        $this->restreindreClient();

        $panierProduit = $this->panierRepository->findOneBy(['utilisateur' => $this->getUtilisateur(), 'produit' => $produitId]);

        PanierController::remettreEnStock($this->em, $panierProduit);

        $this->em->flush();

        return $this->redirectToRoute('panier_panier');
    }

    /**
     * @Route("/vider", name="panier_vider")
     * @throws ORMException
     */
    public function viderAction(): Response
    {
        $this->restreindreClient();

        $panierUtilisateur = $this->panierRepository->findBy(['utilisateur' => $this->getUtilisateur()]);

        foreach ($panierUtilisateur as $panierProduit)
            PanierController::remettreEnStock($this->em, $panierProduit);

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

    /**
     * @param EntityManager $em
     * @param Panier $panierProduit
     * @throws ORMException
     */
    public static function remettreEnStock(EntityManagerInterface $em, Panier $panierProduit): void
    {
        $produit = $panierProduit->getProduit();
        $produit->setQuantite($produit->getQuantite() + $panierProduit->getNbAchete());

        $em->remove($panierProduit);
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */
