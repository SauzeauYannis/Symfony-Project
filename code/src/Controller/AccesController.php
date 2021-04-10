<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccesController extends AbstractController
{
    public function getUtilisateur(): ?Utilisateur
    {
        $utilisateurId = $this->getParameter('id');

        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');

        return $utilisateurRepository->find($utilisateurId);
    }

    public function restreindreNonAuthentifie()
    {
        if ($this->getUtilisateur() != null)
            throw $this->createNotFoundException('Vous devez être non authentifié pour accéder à cette page');
    }

    public function restreindreClientEtAdministrateur()
    {
        if ($this->getUtilisateur() == null)
            throw $this->createNotFoundException('Vous devez être authentifié pour accéder à cette page');
    }
}
