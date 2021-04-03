<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210403092444 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_2129058FF347EFB');
        $this->addSql('DROP INDEX IDX_2129058FFB88E14F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__im2021_panier AS SELECT id, utilisateur_id, produit_id, nb_achete FROM im2021_panier');
        $this->addSql('DROP TABLE im2021_panier');
        $this->addSql('CREATE TABLE im2021_panier --Table du panier du site
        (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, utilisateur_id INTEGER NOT NULL, produit_id INTEGER NOT NULL, nb_achete INTEGER NOT NULL, CONSTRAINT FK_2129058FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES im2021_utilisateurs (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2129058FF347EFB FOREIGN KEY (produit_id) REFERENCES im2021_produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO im2021_panier (id, utilisateur_id, produit_id, nb_achete) SELECT id, utilisateur_id, produit_id, nb_achete FROM __temp__im2021_panier');
        $this->addSql('DROP TABLE __temp__im2021_panier');
        $this->addSql('CREATE INDEX IDX_2129058FF347EFB ON im2021_panier (produit_id)');
        $this->addSql('CREATE INDEX IDX_2129058FFB88E14F ON im2021_panier (utilisateur_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__im2021_produit AS SELECT id, libelle, prix_unitaire, quantite FROM im2021_produit');
        $this->addSql('DROP TABLE im2021_produit');
        $this->addSql('CREATE TABLE im2021_produit --Table des produits du site
        (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL COLLATE BINARY, prix_unitaire DOUBLE PRECISION NOT NULL, quantite INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO im2021_produit (id, libelle, prix_unitaire, quantite) SELECT id, libelle, prix_unitaire, quantite FROM __temp__im2021_produit');
        $this->addSql('DROP TABLE __temp__im2021_produit');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_2129058FFB88E14F');
        $this->addSql('DROP INDEX IDX_2129058FF347EFB');
        $this->addSql('CREATE TEMPORARY TABLE __temp__im2021_panier AS SELECT id, utilisateur_id, produit_id, nb_achete FROM im2021_panier');
        $this->addSql('DROP TABLE im2021_panier');
        $this->addSql('CREATE TABLE im2021_panier --Table du panier du site
        (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, utilisateur_id INTEGER NOT NULL, produit_id INTEGER NOT NULL, nb_achete INTEGER NOT NULL)');
        $this->addSql('INSERT INTO im2021_panier (id, utilisateur_id, produit_id, nb_achete) SELECT id, utilisateur_id, produit_id, nb_achete FROM __temp__im2021_panier');
        $this->addSql('DROP TABLE __temp__im2021_panier');
        $this->addSql('CREATE INDEX IDX_2129058FFB88E14F ON im2021_panier (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_2129058FF347EFB ON im2021_panier (produit_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__im2021_produit AS SELECT id, libelle, prix_unitaire, quantite FROM im2021_produit');
        $this->addSql('DROP TABLE im2021_produit');
        $this->addSql('CREATE TABLE im2021_produit --Table des produits du site
        (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, quantite INTEGER NOT NULL)');
        $this->addSql('INSERT INTO im2021_produit (id, libelle, prix_unitaire, quantite) SELECT id, libelle, prix_unitaire, quantite FROM __temp__im2021_produit');
        $this->addSql('DROP TABLE __temp__im2021_produit');
    }
}
