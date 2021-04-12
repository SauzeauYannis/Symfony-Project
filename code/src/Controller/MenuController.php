<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class MenuController
 * @package App\Controller
 */
class MenuController extends AccesController
{
    /**
     * @return Response
     */
    public function menuAction(): Response
    {
        $produits = $this->produitRepository->findAll();

        $args = [
            'utilisateur' => $this->getUtilisateur(),
            'nombre_de_produits' => count($produits)
        ];
        return $this->render('layout/menu.html.twig', $args);
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */
