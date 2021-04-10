<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
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
class UtilisateurController extends AccesController
{
    /**
     * @Route("/creation", name="utilisateur_creation")
     * @param Request $request
     * @return Response
     */
    public function creationAction(Request $request): Response
    {
        $this->restreindreVisiteur();

        $nouvel_utilisateur = new Utilisateur();

        // gestion du formulaire création de compte
        $form = $this->createForm(UtilisateurType::class, $nouvel_utilisateur);
        $form->add('send', SubmitType::class, ['label' => 'Créer votre compte']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $nouvel_utilisateur = $form->getData();
            $nouvel_utilisateur->setIsadmin(0);
            $nouvel_utilisateur->setMotdepasse(sha1($nouvel_utilisateur->getMotdepasse()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($nouvel_utilisateur);
            $em->flush();

            $this->addFlash('info', 'Votre compte a bien été créé');

            return $this->redirectToRoute("accueil_accueil");
        }

        if ($form->isSubmitted())
            $this->addFlash('error', 'Le formulaire a été mal rempli');

        return $this->render('utilisateur/creation.html.twig', ['create_user_form' => $form->createView()]);
    }

    /**
     * @Route("/edition", name="utilisateur_edition")
     * @param Request $request
     * @return Response
     */
    public function editionAction(Request $request): Response
    {
        $this->restreindreClient();

        $form = $this->createForm(UtilisateurType::class, $this->getUtilisateur());
        $form->add('send', SubmitType::class, ['label' => 'Editer le compte']);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $this->addFlash('info', 'Votre compte a bien été édité');

                return $this->redirectToRoute('produit_liste');
            }
            $this->addFlash('info', 'Les modifications n\'ont pas étés prises en compte');
        }

        return $this->render('utilisateur/edition.html.twig', ['edit_user_form' => $form->createView()]);
    }

    /**
     * @Route("/gestion", name="utilisateur_gestion")
     */
    public function gestionAction(): Response
    {
        $this->restreindreAdministrateur();

        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');


        $utilisateurs = $utilisateurRepository->findAll();

        $args = [
            'utilisateur_courant' => $this->getUtilisateur(),
            'utilisateurs' => $utilisateurs
        ];

        return $this->render('utilisateur/gestion.html.twig', $args);
    }

    /**
     * @Route("/supprimer/{utilisateurId}", name="utilisateur_supprimer")
     * @param $utilisateurId
     * @return Response
     */
    public function supprimerAction($utilisateurId): Response
    {
        $this->restreindreAdministrateur();

        $em = $this->getDoctrine()->getManager();
        $utilisateurRepository = $em->getRepository('App:Utilisateur');
        $panierRepository = $em->getRepository('App:Panier');

        $utilisateur = $utilisateurRepository->find($utilisateurId);
        $panierUtilisateur = $panierRepository->findBy(['utilisateur' => $utilisateur]);

        foreach ($panierUtilisateur as $panierLigne) {
            $produit = $panierLigne->getProduit();
            $produit->setQuantite($produit->getQuantite() + $panierLigne->getNbAchete());
            $em->remove($panierLigne);
        }

        $em->remove($utilisateur);
        $em->flush();

        return $this->redirectToRoute("utilisateur_gestion");
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */