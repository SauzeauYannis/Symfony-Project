<?php

namespace App\Controller;

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

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        $args = ['utilisateur' => $utilisateur];
        return $this->render('panier/panier.html.twig', $args);
    }
}

/* Créé par Yannis Sauzeau et ... */