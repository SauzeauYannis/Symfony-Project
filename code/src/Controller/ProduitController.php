<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProduitController
 * @package App\Controller
 *
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/liste", name="liste_produit")
     */
    public function listeAction(): Response
    {
        return $this->render('produit/liste.html.twig');
    }

    /**
     * @Route("/ajouter", name="ajouter_produit")
     */
    public function ajouterAction(): Response
    {
        return $this->render('produit/ajouter.html.twig');
    }
}

/* Créé par Yannis Sauzeau et ... */