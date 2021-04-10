<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccueilController
 * @package App\Controller
 */
class AccueilController extends AccesController
{
    /**
     * @Route("/", name="accueil_accueil")
     */
    public function accueilAction(): Response
    {
        return $this->render('accueil.html.twig', ['utilisateur' => $this->getUtilisateur()]);
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */