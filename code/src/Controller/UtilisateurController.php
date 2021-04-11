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

        $form = $this->createForm(UtilisateurType::class, $nouvel_utilisateur);
        $form->add('send', SubmitType::class, ['label' => 'Créer votre compte']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if ($this->identifiantUnique($nouvel_utilisateur->getIdentifiant()))
            {
                $nouvel_utilisateur = $form->getData();
                $nouvel_utilisateur->setIsadmin(0);
                $nouvel_utilisateur->setMotdepasse(sha1($nouvel_utilisateur->getMotdepasse()));

                $this->em->persist($nouvel_utilisateur);
                $this->em->flush();

                $this->addFlash('info', 'Votre compte a bien été créé');

                return $this->redirectToRoute("accueil_accueil");
            }

            $this->addFlash('error', 'Cet identifiant est déjà pris, Veuillez en choisir un autre');
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

        $utilisateur = $this->getUtilisateur();

        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->add('send', SubmitType::class, ['label' => 'Editer le compte']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if ($this->identifiantUnique($utilisateur->getIdentifiant()))
            {
                $utilisateur->setMotdepasse(sha1($utilisateur->getMotdepasse()));

                $this->em = $this->getDoctrine()->getManager();
                $this->em->flush();

                $this->addFlash('info', 'Votre compte a bien été édité');

                return $this->redirectToRoute('produit_liste');
            }

            $this->addFlash('error', 'Cet identifiant est déjà pris, Veuillez en choisir un autre');
        }

        if ($form->isSubmitted())
            $this->addFlash('error', 'Le formulaire a été mal rempli');

        return $this->render('utilisateur/edition.html.twig', ['edit_user_form' => $form->createView()]);
    }

    /**
     * @Route("/gestion", name="utilisateur_gestion")
     */
    public function gestionAction(): Response
    {
        $this->restreindreAdministrateur();

        $utilisateurs = $this->utilisateurRepository->findAll();

        $args = [
            'utilisateur_courant' => $this->getUtilisateur(),
            'utilisateurs' => $utilisateurs
        ];

        return $this->render('utilisateur/gestion.html.twig', $args);
    }

    /**
     * @Route(
     *     "/supprimer/{utilisateurId}",
     *     name="utilisateur_supprimer",
     *     requirements={"utilisateurId": "[0-9]+"}
     * )
     * @param $utilisateurId
     * @return Response
     */
    public function supprimerAction($utilisateurId): Response
    {
        $this->restreindreAdministrateur();

        $utilisateur = $this->utilisateurRepository->find($utilisateurId);
        $panierUtilisateur = $this->panierRepository->findBy(['utilisateur' => $utilisateur]);

        foreach ($panierUtilisateur as $panierLigne)
        {
            $produit = $panierLigne->getProduit();
            $produit->setQuantite($produit->getQuantite() + $panierLigne->getNbAchete());

            $this->em->remove($panierLigne);
        }

        $this->em->remove($utilisateur);
        $this->em->flush();

        return $this->redirectToRoute("utilisateur_gestion");
    }

    /**
     * @param String $identifiant
     * @return bool
     */
    private function identifiantUnique(String $identifiant): bool
    {
        foreach ($this->utilisateurRepository->findAll() as $utilisateur)
        {
            if ($utilisateur->getIdentifiant() == $identifiant)
                return false;
        }
        return true;
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */