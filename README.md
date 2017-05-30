# ============== Projet3 ===============
## Repository sur le Projet 3 -Formation OpenClassrooms
_________________________________________________________

## 1er Commit : Mise en place Architecture MVC de base

Dans ce commit, j'ai réalisé les actions suivantes :
- Création du répertoire APP qui contiendra la configuration de l'application;
- Création du répertoire DB  qui contiendra les scripts SQL de création de la base de données;
- Création du répertoire SRC qui contiendra les fichiers source PHP;
- Création du répertoire VIEWS qui contiendra les vues de l'application;
- Création du répertoire WEB qui contiendra les fichiers accessibles aux clients web.
- Création du fichier .gitignore qui permettra d'ignorer certains répertoires et/ou fichiers lors des commit (versionning)

_________________________________________________________

## 2eme Commit : Creation fichier composer et installation des éléments vendors

Ce commit comprends les actions suivantes :
- Création du fichier composer.json permettant de récupérer un certains nombres d'éléments pour automatiser notre application :
-- MiniFramework Silex
-- Module Doctrine/DBAL
-- Module Twig
-- Twig-bridge et asset pour simplfier la partie mise en forme (CSS, JS, etc...)
- Création des répertoires : bootstrap, jquery et js

___________________________________________________________

## 3eme Commit : Création des fichiers UML V1 et un jeu d essai BDD

Ce commit contient :
- Création du répertoire UML qui contiendra les fichiers créés avec DIA schématisant les futures classes du projet.
- Création du Diagramme UML (Version 1)
- Copie des fichiers DB : Structure.sql et Contents.sql pour un jeu d'essai

___________________________________________________________

## 4eme Commit : Création de l'interface Frontend - 1ere partie

Ce commit contient :
- Création des 3 premiers fichiers MVC de base pour lister les episodes.
-- Index.php : qui contient maintenant que le lien entre acces aux données(model.php) et présentation (View.php)
-- Model.php : qui contient la fonction qui se connecte à la base et execute la requete d'affichage de tous les episodes
-- View.php : qui contient le code HTML et PHP permettant l'affichage basic des episodes.
- Mise en place des fichiers dans les répertoires MVC de base *(SRC=model.php)* , *(VIEWS=view.php)*, *(WEB=index.php)*.
- Création du fichier routes.php dans le répertoire APP suite à l'installation de Silex dans le commit 2.
