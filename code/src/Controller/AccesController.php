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

    public function restreindreVisiteur()
    {
        if ($this->getUtilisateur() != null)
            throw $this->createNotFoundException('Vous devez être non authentifié pour accéder à cette page');
    }

    public function restreindreClient()
    {
        if ($this->getUtilisateur() == null || $this->getUtilisateur()->getIsadmin() == 1)
            throw $this->createNotFoundException('Vous devez être client pour accéder à cette page');
    }

    public function restreindreAdministrateur()
    {
        if ($this->getUtilisateur() == null || $this->getUtilisateur()->getIsadmin() != 1)
            throw $this->createNotFoundException('Vous devez être administrateur pour accéder à cette page');
    }

    public function restreindreClientEtAdministrateur()
    {
        if ($this->getUtilisateur() == null)
            throw $this->createNotFoundException('Vous devez être authentifié pour accéder à cette page');
    }
}
