# ============== Projet3 ===============
## Repository sur le Projet 3 - Formation OpenClassrooms
_________________________________________________________

## 1er Commit : Mise en place Architecture MVC de base

Dans ce commit, j'ai réalisé les actions suivantes :
- Création du répertoire **APP** qui contiendra la configuration de l'application;
- Création du répertoire **DB**  qui contiendra les scripts SQL de création de la base de données;
- Création du répertoire **SRC** qui contiendra les fichiers source PHP;
- Création du répertoire **VIEWS** qui contiendra les vues de l'application;
- Création du répertoire **WEB** qui contiendra les fichiers accessibles aux clients web.
- Création du fichier .gitignore qui permettra d'ignorer certains répertoires et/ou fichiers lors des commit (versionning)

_________________________________________________________

## 2eme Commit : Creation fichier composer et installation des éléments vendors

Ce commit comprends les actions suivantes :
- Création du fichier *composer.json* permettant de récupérer un certains nombres d'éléments pour automatiser notre application :
-- MiniFramework Silex
-- Module Doctrine/DBAL
-- Module Twig
-- Twig-bridge et asset pour simplfier la partie mise en forme (CSS, JS, etc...)
- Création des répertoires : **bootstrap**, **jquery** et **js**

___________________________________________________________

## 3eme Commit : Création des fichiers UML V1 et un jeu d essai BDD

Ce commit contient :
- Création du répertoire **UML** qui contiendra les fichiers créés avec DIA schématisant les futures classes du projet.
- Création du Diagramme UML (Version 1)
- Copie des fichiers DB : *Structure.sql* et *Contents.sql* pour un jeu d'essai

___________________________________________________________

## 4eme Commit : Création de l'interface Frontend - 1ere partie

Ce commit contient :
- Création des 3 premiers fichiers *MVC* de base pour lister les episodes.
-- *Index.php* : qui contient maintenant que le lien entre acces aux données(model.php) et présentation (View.php)
-- *Model.php* : qui contient la fonction qui se connecte à la base et execute la requete d'affichage de tous les episodes
-- *View.php* : qui contient le code HTML et PHP permettant l'affichage basic des episodes.
- Mise en place des fichiers dans les répertoires MVC de base *(SRC=model.php)* , *(VIEWS=view.php)*, *(WEB=index.php)*.
- Création du fichier *routes.php* dans le répertoire **APP** suite à l'installation de Silex dans le commit 2.

___________________________________________________________

## 5eme Commit : Modélisation Oienté Objet des Données Episodes

Ce commit contient :
- Modélisation de la class *Episode.php* + création du dossier **SRC\Domain**
- Remplacement de la technologie PDO (*connexion à la base*) par **DBAL** : EpisodeDAO.php
- Création du répertoire **SRC\DAO**.
- Création d'un fichier *app.php* se trouvant dans **app**.
- Création des fichiers *prod.php* et *dev.php* dans le répertoire **app\Config**;
- Modification du fichier *view.php* pour remplacer le tableau associatif des episodes par l'appel des methodes de la class Episode.

___________________________________________________________

## 6eme Commit : Utilisation du composant Twig pour améliorer les vues

Ce commit contient :
- La mise en place de Twig dans nos vues actuelles et futures.
- Cela permettra en autre de proteger des injections de code (en appliquant par exemple l'echappement des varaibles dynamiquement) et d'optimiser les parties communes à l'ensemble de nos pages.
- Modification du fichier *app.php* pour y ajouter l'enregistrement de Twig aupres de Silex.
- Remplacons le fichier *view.php* par le fichier *index.html.twig*.
- Modification du fichier *routes.php* pour qu'il génére la nouvelle vue.
