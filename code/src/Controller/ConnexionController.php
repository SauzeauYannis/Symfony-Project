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
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        if ($utilisateur != null)
            throw $this->createNotFoundException('Vous devez être non authentifié pour accéder à cette page');

        return $this->render('connexion/se_connecter.html.twig');
    }

    /**
     * @Route("/se_deconnecter", name="se_deconnecter")
     */
    public function seDeconnecterAction(): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        if ($utilisateur == null)
            throw $this->createNotFoundException('Vous devez être authentifié pour accéder à cette page');

        $this->addFlash('info', 'Vous avez été correctement déconnecté');

        $args = ['utilisateur' => $utilisateur];
        return $this->render('accueil.html.twig', $args);
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */