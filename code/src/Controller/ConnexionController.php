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
        return $this->render('connexion/se_connecter.html.twig');
    }

    /**
     * @Route("/se_deconnecter", name="se_deconnecter")
     */
    public function seDeconnecterAction(): Response
    {
        return $this->render('connexion/se_deconnecter.html.twig');
    }
}

/* Créé par Yannis Sauzeau et ... */