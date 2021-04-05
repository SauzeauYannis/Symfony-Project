<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends AbstractController
{
    /**
     * @return Response
     */
    public function menuAction(): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');
        $produitRepository = $em->getRepository('App:Produit');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        $produits = $produitRepository->findAll();

        $args = [
            'utilisateur' => $utilisateur,
            'nombre_de_produits' => count($produits)
        ];
        return $this->render('layout/menu.html.twig', $args);
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */