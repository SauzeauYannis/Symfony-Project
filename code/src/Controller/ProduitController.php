<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function listeAction(): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');
        $produitRepository = $em->getRepository('App:Produit');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        if ($utilisateur == null || $utilisateur->getIsadmin() == 1)
            throw $this->createNotFoundException('Vous devez être client pour accéder à cette page');

        $produits = $produitRepository->findAll();

        foreach ($_POST as $key => $value)
            $this->addFlash('info', '$key = ' . $key . ' and $value = ' . $value);

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