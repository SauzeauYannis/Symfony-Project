<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\ORMException;
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

        return $this->formulaireUtilisateur($request, new Utilisateur(), true);
    }

    /**
     * @Route("/edition", name="utilisateur_edition")
     * @param Request $request
     * @return Response
     */
    public function editionAction(Request $request): Response
    {
        $this->restreindreClient();

        return $this->formulaireUtilisateur($request, $this->getUtilisateur(), false);
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
     * @throws ORMException
     */
    public function supprimerAction($utilisateurId): Response
    {
        $this->restreindreAdministrateur();

        $utilisateur = $this->utilisateurRepository->find($utilisateurId);
        $panierUtilisateur = $this->panierRepository->findBy(['utilisateur' => $utilisateur]);

        foreach ($panierUtilisateur as $panierProduit)
            PanierController::remettreEnStock($this->em, $panierProduit);

        $this->em->remove($utilisateur);
        $this->em->flush();

        return $this->redirectToRoute("utilisateur_gestion");
    }

    /**
     * @param Request $request
     * @param Utilisateur $utilisateur
     * @param bool $estNouveau
     * @return Response
     */
    private function formulaireUtilisateur(Request $request, Utilisateur $utilisateur, bool $estNouveau): Response
    {
        $ancienIdentifiant = $utilisateur->getIdentifiant();

        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->add('send', SubmitType::class, ['label' => 'Valider']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if ($this->identifiantUnique($utilisateur->getIdentifiant(), $ancienIdentifiant))
            {
                $utilisateur->setMotdepasse(sha1($utilisateur->getMotdepasse()));

                if ($estNouveau)
                {
                    $utilisateur->setIsadmin(0);
                    $this->em->persist($utilisateur);
                }

                $this->em->flush();

                $this->addFlash('info', 'Le formulaire a été envoyé');

                return $this->redirectToRoute("accueil_accueil");
            }

            $this->addFlash('error', 'Cet identifiant est déjà pris, Veuillez en choisir un autre');
        }

        if ($form->isSubmitted())
            $this->addFlash('error', 'Le formulaire a été mal rempli');

        if ($estNouveau)
            return $this->render('utilisateur/creation.html.twig', ['create_user_form' => $form->createView()]);
        else
            return $this->render('utilisateur/edition.html.twig', ['edit_user_form' => $form->createView()]);
    }

    /**
     * @param string $nouveauIdentifiant
     * @param string|null $ancienIdentifiant
     * @return bool
     */
    private function identifiantUnique(string $nouveauIdentifiant, ?string $ancienIdentifiant): bool
    {
        foreach ($this->utilisateurRepository->findAll() as $utilisateur)
        {
            if ($utilisateur->getIdentifiant() == $nouveauIdentifiant && $nouveauIdentifiant != $ancienIdentifiant)
                return false;
        }
        return true;
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */
