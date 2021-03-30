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
        return $this->render('utilisateur/creation.html.twig');
    }

    /**
     * @Route("/edition", name="edition_utilisateur")
     */
    public function editionAction(): Response
    {
        return $this->render('utilisateur/edition.html.twig');
    }

    /**
     * @Route("/gestion", name="gestion_utilisateur")
     */
    public function gestionAction(): Response
    {
        return $this->render('utilisateur/gestion.html.twig');
    }
}

/* Créé par Yannis Sauzeau et ... */