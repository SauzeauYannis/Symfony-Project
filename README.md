# Symfony-Project

##### Table of Contents
* [Français](#fr)
  * [Présentation](#fr_pr)
  * [Utilisation](#fr_ut)
  * [Compétences acquises](#fr_cp)
  * [Résultat](#fr_rs)
* [English](#en)
  * [Presentation](#en_pr)
  * [Use](#en_u)
  * [Skills acquired](#en_sk)
  * [Result](#en_rs)

<a name="fr"/>

## Français

<a name="fr_pr"/>

### Présentation

Ce projet a été effectué en troisième année du [CMI Informatique](http://formations.univ-poitiers.fr/fr/index/autre-diplome-niveau-master-AM/autre-diplome-niveau-master-AM/cmi-informatique-JD2XQGVY.html) à l'[UFR SFA Université de Poitiers](https://sfa.univ-poitiers.fr/) dans le cadre de l'enseignement [Technologies du Web 2](http://formations.univ-poitiers.fr/fr/index/autre-diplome-niveau-master-AM/autre-diplome-niveau-master-AM/cmi-informatique-JD2XQGVY/specialite-s6-K5C7D86V/technologies-du-web-2-JB1YISDE.html).

Ce projet a été développé en binôme avec l'EDI [PhpStorm](https://www.jetbrains.com/phpstorm/) et [WampServer](https://www.wampserver.com/2021/03/24/from-the-present-generation-of-academic-writing-college-essay-editing-services-have-become-an-essential-necessity/).

<a name="fr_ut"/>

### Utilisation

Pour lancer le site il faut installer [Symfony](https://symfony.com/download) et [Composer](https://getcomposer.org/doc/00-intro.md).

Dans le dossier [code](https://github.com/SauzeauYannis/Symfony-Project/tree/main/code) lancez les commandes :

```shell
$ composer install
$ symfony console doctrine:fixtures:load
```

Ensuite, copiez-collez ce dossier dans un serveur local et lancez le site à l'adresse http://localhost/code/public/.

Vous pouvez maintenant vous déplacer dans le site avec le menu.

Il y a trois types d'utilisateur qui ont accès à des pages différentes : visiteur, client et administrateur.

Pour changer d'utilisateur, il faut éditer le paramètre id dans le fichier [services.yaml](https://github.com/SauzeauYannis/Symfony-Project/blob/main/code/config/services.yaml).

<a name="fr_cp"/>

### Compétences acquises

* Langage PHP et framework Symfony
  * Architecture MVC
  * Système de route et réponse
  * Base de données avec Doctrine
  * Formulaire
  * Gestion des niveaux d'accès
  * Sécurité
  * Vue avec Twig
  * Envoi de mail avec swiftMailer

<a name="fr_rs"/>

### Résultat

Nous avons obtenu la note de ?/20. (Résultat en juillet)

<a name="en"/>

## English

<a name="en_pr"/>

### Presentation

This project was carried out in the third year of the [CMI Informatique](http://formations.univ-poitiers.fr/fr/index/autre-diplome-niveau-master-AM/autre-diplome-niveau-master-AM/cmi-informatique-JD2XQGVY.html) at the [University of Poitiers](https://www.univ-poitiers.fr/en/) as part of the [Web 2 technologies](http://formations.univ-poitiers.fr/fr/index/autre-diplome-niveau-master-AM/autre-diplome-niveau-master-AM/cmi-informatique-JD2XQGVY/specialite-s6-K5C7D86V/technologies-du-web-2-JB1YISDE.html) teaching programme.

This project was developed in pairs with the [PhpStorm](https://www.jetbrains.com/phpstorm/) IDE and [WampServer](https://www.wampserver.com/en/).

<a name="en_u"/>

### Use

To launch the site you need to install [Symfony](https://symfony.com/download) and [Composer](https://getcomposer.org/doc/00-intro.md).

In the [code](https://github.com/SauzeauYannis/Symfony-Project/tree/main/code) folder run the commands :

```shell
$ composer install
$ symfony console doctrine:fixtures:load
```

Then, copy and paste this folder into a local server and launch the site at http://localhost/code/public/.

You can now move around the site with the menu.

There are three types of users who have access to different pages: visitor, client and administrator.

To change the user, you have to edit the id parameter in the [services.yaml](https://github.com/SauzeauYannis/Symfony-Project/blob/main/code/config/services.yaml) file .

<a name="en_sk"/>

### Skills acquired

* PHP language and Symfony framework
  * MVC architecture
  * Route and response system
  * Database with Doctrine
  * Form
  * Access level management
  * Security
  * View with Twig
  * Sending mail with swiftMailer
  
<a name="en_rs"/>

### Result

We obtained a score of ?/20. (Result in July)
