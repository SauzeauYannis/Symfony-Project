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
        return $this->render('panier/panier.html.twig');
    }
}

/* Créé par Yannis Sauzeau et ... */