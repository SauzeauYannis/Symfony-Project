<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProduitController
 * @package App\Controller
 *
 * @Route("/produit")
 */
class ProduitController extends AccesController
{
    /**
     * @Route("/liste", name="produit_liste")
     */
    public function listeAction(Request $request): Response
    {
        $this->restreindreClient();

        $em = $this->getDoctrine()->getManager();
        $produitRepository = $em->getRepository('App:Produit');

        if (!empty($request->request->all()))
        {
            $panierRepository = $em->getRepository('App:Panier');

            foreach ($request->request->all() as $produitId => $quantite)
            {
                $produit = $produitRepository->find($produitId);
                $produitQuantite = $produit->getQuantite();

                if ($quantite < 0 || $quantite > $produitQuantite)
                    throw $this->createNotFoundException('Erreur lors du traitement du formulaire');
                else if ($quantite != 0)
                {
                    $utilisateur = $this->getUtilisateur();
                    $panier = $panierRepository->findOneBy(['utilisateur' => $utilisateur, 'produit' => $produit]);
                    if ($panier == null)
                    {
                        $nouveauPanier = new Panier();
                        $nouveauPanier->setUtilisateur($utilisateur)
                            ->setProduit($produit)
                            ->setNbAchete($quantite);
                        $em->persist($nouveauPanier);
                    }
                    else
                    {
                        $panier->setNbAchete($panier->getNbAchete() + $quantite);
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
     * @Route("/ajouter", name="produit_ajouter")
     */
    public function ajouterAction(Request $request): Response
    {
        $this->restreindreAdministrateur();

        $nouveau_produit = new Produit();

        $form = $this->createForm(ProduitType::class, $nouveau_produit);
        $form->add('send', SubmitType::class, ['label' => 'Ajouter le produit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $nouveau_produit = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($nouveau_produit);
            $em->flush();

            $this->addFlash('info', 'Le produit a bien été ajouté');

            return $this->redirectToRoute("accueil_accueil");
        }

        if ($form->isSubmitted())
            $this->addFlash('error', 'Le formulaire a été mal rempli');

        $args = array('ajouter_produit' => $form->createView());
        return $this->render('/produit/ajouter.html.twig', $args);
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */