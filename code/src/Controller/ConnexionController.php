<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ConnexionController
 * @package App\Controller
 *
 * @Route("/connexion")
 */
class ConnexionController extends AbstractController
{
    /**
     * @Route("/se_connecter", name="se_connecter")
     */
    public function seConnecterAction(): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        $args = ['utilisateur' => $utilisateur];
        return $this->render('connexion/se_connecter.html.twig', $args);
    }

    /**
     * @Route("/se_deconnecter", name="se_deconnecter")
     */
    public function seDeconnecterAction(): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        $args = ['utilisateur' => $utilisateur];
        return $this->render('connexion/se_deconnecter.html.twig', $args);
    }
}

/* Créé par Yannis Sauzeau et ... */