<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ConnexionController
 * @package App\Controller
 *
 * @Route("/connexion")
 */
class ConnexionController extends AccesController
{
    /**
     * @Route("/se_connecter", name="connexion_se_connecter")
     */
    public function seConnecterAction(): Response
    {
        $this->restreindreNonAuthentifie();

        return $this->render('connexion/se_connecter.html.twig');
    }

    /**
     * @Route("/se_deconnecter", name="connexion_se_deconnecter")
     */
    public function seDeconnecterAction(): Response
    {
        $this->restreindreClientEtAdministrateur();

        $this->addFlash('info', 'Vous avez été correctement déconnecté');

        return $this->redirectToRoute('accueil_accueil');
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */