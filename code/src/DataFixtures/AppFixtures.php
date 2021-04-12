<?php

namespace App\DataFixtures;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $utilisateur1 = new Utilisateur();
        $utilisateur1->setIdentifiant("admin")
            ->setMotdepasse("nimda")
            ->setIsadmin(1);
        $manager->persist($utilisateur1);

        $utilisateur2 = new Utilisateur();
        $utilisateur2->setIdentifiant("gilles")
            ->setMotdepasse("sellig")
            ->setNom("Subrenat")
            ->setPrenom("Gilles")
            ->setAnniversaire(new \DateTime("2000-01-01"))
            ->setIsadmin(0);
        $manager->persist($utilisateur2);

        $utilisateur3 = new Utilisateur();
        $utilisateur3->setIdentifiant("rita")
            ->setMotdepasse("atir")
            ->setNom("Zrour")
            ->setPrenom("Rita")
            ->setAnniversaire(new \DateTime("2001-01-02"))
            ->setIsadmin(0);
        $manager->persist($utilisateur3);

        $utilisateur4 = new Utilisateur();
        $utilisateur4->setIdentifiant("yannis")
            ->setMotdepasse("snayni")
            ->setNom("Sauzeau")
            ->setPrenom("Yannis")
            ->setAnniversaire(new \DateTime("2000-08-02"))
            ->setIsadmin(0);
        $manager->persist($utilisateur4);

        $utilisateur5 = new Utilisateur();
        $utilisateur5->setIdentifiant("benjamin")
            ->setMotdepasse("jambinen")
            ->setNom("Chevais")
            ->setPrenom("Benjamin")
            ->setAnniversaire(new \DateTime("2000-07-25"))
            ->setIsadmin(0);
        $manager->persist($utilisateur5);

        $produit1 = new Produit();
        $produit1->setLibelle("Bitcoin")
            ->setPrixUnitaire(1)
            ->setQuantite(85);
        $manager->persist($produit1);

        $produit2 = new Produit();
        $produit2->setLibelle("YannisCoin")
            ->setPrixUnitaire(200)
            ->setQuantite(50);
        $manager->persist($produit2);

        $produit3 = new Produit();
        $produit3->setLibelle("BenCoin")
            ->setPrixUnitaire(200)
            ->setQuantite(35);
        $manager->persist($produit3);

        $produit4 = new Produit();
        $produit4->setLibelle("Dollar")
            ->setPrixUnitaire(0.01)
            ->setQuantite(800);
        $manager->persist($produit4);

        $produit5 = new Produit();
        $produit5->setLibelle("NullCoin")
            ->setPrixUnitaire(50000)
            ->setQuantite(100);
        $manager->persist($produit5);

        $panier1 = new Panier();
        $panier1->setUtilisateur($utilisateur2)
            ->setProduit($produit2)
            ->setNbAchete(20);
        $manager->persist($panier1);

        $panier2 = new Panier();
        $panier2->setUtilisateur($utilisateur2)
            ->setProduit($produit3)
            ->setNbAchete(35);
        $manager->persist($panier2);

        $panier3 = new Panier();
        $panier3->setUtilisateur($utilisateur2)
            ->setProduit($produit4)
            ->setNbAchete(50);
        $manager->persist($panier3);

        $panier4 = new Panier();
        $panier4->setUtilisateur($utilisateur4)
            ->setProduit($produit1)
            ->setNbAchete(5);
        $manager->persist($panier4);

        $panier5 = new Panier();
        $panier5->setUtilisateur($utilisateur4)
            ->setProduit($produit3)
            ->setNbAchete(10);
        $manager->persist($panier5);

        $panier6 = new Panier();
        $panier6->setUtilisateur($utilisateur4)
            ->setProduit($produit4)
            ->setNbAchete(50);
        $manager->persist($panier6);

        $manager->flush();
    }
}
