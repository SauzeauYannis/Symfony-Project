<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Form\ProduitType;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProduitController
 * @package App\Controller
 *
 * @Route("/produit")
 */
class ProduitController extends AccesController
{
    /**
     * @Route("/liste", name="produit_liste")
     */
    public function listeAction(Request $request): Response
    {
        $this->restreindreClient();

        $postParams = $request->request->all();

        if (!empty($postParams))
        {
            $panierRepository = $this->em->getRepository('App:Panier');

            foreach ($postParams as $produitId => $quantite)
            {
                $produit = $this->produitRepository->find($produitId);
                $produitQuantite = $produit->getQuantite();

                if ($quantite < 0 || $quantite > $produitQuantite)
                    throw $this->createNotFoundException('Erreur lors du traitement du formulaire');
                else if ($quantite != 0)
                {
                    $utilisateur = $this->getUtilisateur();
                    $panierProduit = $panierRepository->findOneBy(['utilisateur' => $utilisateur, 'produit' => $produit]);

                    if ($panierProduit == null)
                    {
                        $nouveauPanier = new Panier();
                        $nouveauPanier->setUtilisateur($utilisateur)
                            ->setProduit($produit)
                            ->setNbAchete($quantite);

                        $this->em->persist($nouveauPanier);
                    }
                    else
                        $panierProduit->setNbAchete($panierProduit->getNbAchete() + $quantite);

                    $produit->setQuantite($produitQuantite - $quantite);

                    $this->em->flush();
                }
            }
        }

        return $this->render('produit/liste.html.twig', ['produits' => $this->produitRepository->findAll()]);
    }

    /**
     * @Route("/ajouter", name="produit_ajouter")
     */
    public function ajouterAction(Request $request): Response
    {
        $this->restreindreAdministrateur();

        $nouveau_produit = new Produit();

        $form = $this->createForm(ProduitType::class, $nouveau_produit);
        $form->add('send', SubmitType::class, ['label' => 'Ajouter le produit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $nouveau_produit = $form->getData();

            $this->em->persist($nouveau_produit);
            $this->em->flush();

            $this->addFlash('info', 'Le produit a bien été ajouté');

            return $this->redirectToRoute("accueil_accueil");
        }

        if ($form->isSubmitted())
            $this->addFlash('error', 'Le formulaire a été mal rempli');

        return $this->render('/produit/ajouter.html.twig', ['ajouter_produit' => $form->createView()]);
    }

    /**
     * @Route("/send_mail", name="produit_mail")
     * @param Swift_Mailer $mailer
     * @return Response
     */
    public function mailAction(Swift_Mailer $mailer): Response
    {
        // Changer cette variable selon l'adresse mail utilisée dans la variable MAILER_URL du fichier .env.local
        $mail = 'studecook@gmail.com';

        $produits = $this->produitRepository->findAll();

        $message = (new Swift_Message('Nombre de produit'))
            ->setFrom($mail)
            ->setTo($mail)
            ->setBody('Il y a ' . count($produits) . ' produit(s) sur le site !');
        $mailer->send($message);

        $this->addFlash('info', 'votre message a bien été envoyé');

        return $this->render('produit/liste.html.twig', ['produits' => $produits]);
    }
}

/* Créé par Yannis Sauzeau et Benjamin Chevais */
