<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccueilController
 * @package App\Controller
 */
class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueilAction(): Response
    {
        return $this->render('accueil.html.twig');
    }
}

/* Créé par Yannis Sauzeau et ... */