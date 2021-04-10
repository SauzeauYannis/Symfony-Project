<?php

namespace App\Controller;

use App\Services\MyService;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route ("/service", name="accueil_service")
     */
    public function serviceAction(MyService $myService){
        // le Myservice passé en paramètre est instancié au moment de l'appel

        $tab = [1, 2, 3, 4];
        $result = $myService->countTab($tab);

        $args = array('tab' => $tab,
            'result' => $result);

        return $this->render('service/service.html.twig', $args);
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */