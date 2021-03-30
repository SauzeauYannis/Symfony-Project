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

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        $args = ['utilisateur' => $utilisateur];
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

        $args = ['utilisateur' => $utilisateur];
        return $this->render('produit/ajouter.html.twig', $args);
    }
}

/* Créé par Yannis Sauzeau et ... */