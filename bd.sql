INSERT INTO im2021_utilisateurs (pk, identifiant, motdepasse, nom, prenom, anniversaire, isadmin) VALUES (31, 'admin', 'a4cbb2f3933c5016da7e83fd135ab8a48b67bf61', null, null, null, 1);
INSERT INTO im2021_utilisateurs (pk, identifiant, motdepasse, nom, prenom, anniversaire, isadmin) VALUES (32, 'gilles', 'ab9240da95937a0d51b41773eafc8ccb8e7d58b5', 'Subrenat', 'Gilles', '2000-01-01', 0);
INSERT INTO im2021_utilisateurs (pk, identifiant, motdepasse, nom, prenom, anniversaire, isadmin) VALUES (33, 'rita', '1811ed39aa69fa4da3c457bdf096c1f10cf81a9b', 'Zrour', 'Rita', '2001-01-02', 0);
INSERT INTO im2021_utilisateurs (pk, identifiant, motdepasse, nom, prenom, anniversaire, isadmin) VALUES (34, 'yannis', 'c7da01026b9470789bc7b0c03f31d295c1cec8c4', 'Sauzeau', 'Yannis', '2000-08-02', 0);
INSERT INTO im2021_utilisateurs (pk, identifiant, motdepasse, nom, prenom, anniversaire, isadmin) VALUES (35, 'benjamin', '42f0bc8a3066e99497b85567056501ec3a4f2ebe', 'Chevais', 'Benjamin', '2000-07-25', 0);

INSERT INTO im2021_produit (id, libelle, prix_unitaire, quantite) VALUES (25, 'Bitcoin', 1, 100);
INSERT INTO im2021_produit (id, libelle, prix_unitaire, quantite) VALUES (26, 'YannisCoin', 200, 50);
INSERT INTO im2021_produit (id, libelle, prix_unitaire, quantite) VALUES (27, 'BenCoin', 200, 50);
INSERT INTO im2021_produit (id, libelle, prix_unitaire, quantite) VALUES (28, 'Dollar', 0.01, 800);
INSERT INTO im2021_produit (id, libelle, prix_unitaire, quantite) VALUES (29, 'NullCoin', 50000, null);

INSERT INTO im2021_panier (id, utilisateur_id, produit_id, nb_achete) VALUES (49, 32, 26, 20);
INSERT INTO im2021_panier (id, utilisateur_id, produit_id, nb_achete) VALUES (50, 32, 27, 35);
INSERT INTO im2021_panier (id, utilisateur_id, produit_id, nb_achete) VALUES (51, 32, 28, 50);
INSERT INTO im2021_panier (id, utilisateur_id, produit_id, nb_achete) VALUES (52, 34, 25, 5);
INSERT INTO im2021_panier (id, utilisateur_id, produit_id, nb_achete) VALUES (53, 34, 27, 10);
INSERT INTO im2021_panier (id, utilisateur_id, produit_id, nb_achete) VALUES (54, 34, 28, 50);

