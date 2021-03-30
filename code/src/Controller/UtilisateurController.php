<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UtilisateurController
 * @package App\Controller
 *
 * @Route("/utilisateur")
 */
class UtilisateurController extends AbstractController
{
    /**
     * @Route("/creation", name="creation_utilisateur")
     */
    public function creationAction(): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        $args = ['utilisateur' => $utilisateur];
        return $this->render('utilisateur/creation.html.twig', $args);
    }

    /**
     * @Route("/edition", name="edition_utilisateur")
     */
    public function editionAction(): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        $args = ['utilisateur' => $utilisateur];
        return $this->render('utilisateur/edition.html.twig', $args);
    }

    /**
     * @Route("/gestion", name="gestion_utilisateur")
     */
    public function gestionAction(): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        $args = ['utilisateur' => $utilisateur];
        return $this->render('utilisateur/gestion.html.twig', $args);
    }
}

/* Créé par Yannis Sauzeau et ... */