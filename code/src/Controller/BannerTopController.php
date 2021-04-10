<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class BannerTopController extends AccesController
{
    /**
     * @return Response
     */
    public function bannerAction(): Response
    {
        return $this->render('layout/banner_top.html.twig', ['utilisateur' => $this->getUtilisateur()]);
    }
}
