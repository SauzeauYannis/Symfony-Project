<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UtilisateurController
 * @package App\Controller
 *
 * @Route("/utilisateur")
 */
class UtilisateurController extends AbstractController
{
    /**
     * @Route("/creation", name="creation_utilisateur")
     * @param Request $request
     * @return Response
     */
    public function creationAction(Request $request): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        if ($utilisateur != null)
            throw $this->createNotFoundException('Vous devez être non authentifié pour accéder à cette page');

        $nouvel_utilisateur = new Utilisateur();

        // gestion du formulaire création de compte
        $form = $this->createForm(UtilisateurType::class, $nouvel_utilisateur);
        $form->add('send', SubmitType::class, ['label' => 'Créer votre compte']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $nouvel_utilisateur = $form->getData();
            $nouvel_utilisateur->setIsadmin(0);
            $em->persist($nouvel_utilisateur);
            $em->flush();
            $this->addFlash('info', 'Votre compte a bien été créé');
            return $this->redirectToRoute("accueil");
        }

        $args = array('create_user_form' => $form->createView());
        return $this->render('utilisateur/creation.html.twig', $args);
    }

    /**
     * @Route("/edition", name="edition_utilisateur")
     * @param Request $request
     * @return Response
     */
    public function editionAction(Request $request): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        if ($utilisateur == null || $utilisateur->getIsadmin() == 1)
            throw $this->createNotFoundException('Vous devez être client pour accéder à cette page');

        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->add('send', SubmitType::class, ['label' => 'Editer le compte']);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $em->flush();
                $this->addFlash('info', 'Les modifications ont bien étés prises en compte');
                return $this->redirectToRoute('liste_produit');
            }
            $this->addFlash('info', 'Les modifications n\'ont pas étés prises en compte');
        }

        $args = array('edit_user_form' => $form->createView());
        return $this->render('utilisateur/edition.html.twig', $args);
    }

    public function viderForUserAction($userId)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');
        $panierRepository = $em->getRepository('App:Panier');

        $utilisateur = $utilisateurRepository->find($userId);

        if ($utilisateur == null || $utilisateur->getIsadmin() == 1)
            throw $this->createNotFoundException('Vous devez être client pour accéder à cette page');

        $panierUtilisateur = $panierRepository->findBy(['utilisateur' => $utilisateur]);

        foreach ($panierUtilisateur as $panierLigne) {
            $produit = $panierLigne->getProduit();
            $produit->setQuantite($produit->getQuantite() + $panierLigne->getNbAchete());
            $em->remove($panierLigne);
        }

        $em->flush();
    }

    /**
     * @Route("/supprimer/{userId}", name="supprimer_utilisateur")
     * @param $userId
     * @return Response
     */
    public function supprimerAction($userId): Response
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');
        $utilisateur = $utilisateurRepository->find($userId);

        $userId.$this->viderForUserAction($userId);

        $em->remove($utilisateur);
        $em->flush();

        return $this->redirectToRoute("gestion_utilisateur");
    }

    /**
     * @Route("/gestion", name="gestion_utilisateur")
     */
    public function gestionAction(): Response
    {
        $utilisateurId = $this->getParameter('id');
        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');

        $utilisateur = $utilisateurRepository->find($utilisateurId);

        if ($utilisateur == null || $utilisateur->getIsadmin() != 1)
            throw $this->createNotFoundException('Vous devez être administrateur pour accéder à cette page');

        $utilisateurs = $utilisateurRepository->findAll();

        $args = array(
            'utilisateur_courant' => $utilisateur,
            'utilisateurs' => $utilisateurs);

        return $this->render('utilisateur/gestion.html.twig', $args);
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */