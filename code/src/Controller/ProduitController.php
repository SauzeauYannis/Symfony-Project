<?php

namespace App\Controller;

use App\Entity\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProduitController
 * @package App\Controller
 *
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/liste", name="liste_produit")
     */
    public function listeAction(Request $request): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');
        $produitRepository = $em->getRepository('App:Produit');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        if ($utilisateur == null || $utilisateur->getIsadmin() == 1)
            throw $this->createNotFoundException('Vous devez être client pour accéder à cette page');

        if (!empty($request->request->all()))
        {
            $panierRepository = $em->getRepository('App:Panier');

            foreach ($request->request->all() as $id => $quantite)
            {
                $produit = $produitRepository->find($id);
                $produitQuantite = $produit->getQuantite();

                if ($quantite < 0 || $quantite > $produitQuantite)
                    throw $this->createNotFoundException('Erreur lors du traitement du formulaire');
                else if ($quantite != 0)
                {
                    $panier = $panierRepository->findBy(['utilisateur' => $utilisateur, 'produit' => $produit]);
                    if (empty($panier))
                    {
                        $nouveauPanier = new Panier();
                        $nouveauPanier->setUtilisateur($utilisateur)
                            ->setProduit($produit)
                            ->setNbAchete($quantite);
                        $em->persist($nouveauPanier);
                    }
                    else
                    {
                        $panier[0]->setNbAchete($panier[0]->getNbAchete() + $quantite);
                    }

                    $produit->setQuantite($produitQuantite - $quantite);

                    $em->flush();
                }
            }
        }

        $produits = $produitRepository->findAll();

        $args = ['produits' => $produits];
        return $this->render('produit/liste.html.twig', $args);
    }

    /**
     * @Route("/ajouter", name="ajouter_produit")
     */
    public function ajouterAction(): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        if ($utilisateur == null || $utilisateur->getIsadmin() != 1)
            throw $this->createNotFoundException('Vous devez être administrateur pour accéder à cette page');

        return $this->render('produit/ajouter.html.twig');
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */