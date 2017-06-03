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
-- Twig-bridge et asset pour simplifier la partie mise en forme (CSS, JS, etc...)
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

___________________________________________________________

## 7eme Commit : Utilisation des composants BootStrap & JQuery pour améliorer les vues

Ce commit contient :
- Etant donné que les composants ont déjà été installé lors du commit N°2, nous allons simplement modifier le fichier *app.php* pour déclarer le service **AssetServiceProvider** qui permettra de simplifier la mise en forme de nos pages.
- Modification de notre vue *index.html.twig* en y intégrant les éléments de BootStrap
- Ajout de quelques éléments CSS dans notre fichier *projet3.css*.

___________________________________________________________

## 8eme Commit : Affichages des commentaires sur un Episode

Ce commit contient :
- Ajout de la table **Commentaires**, mais avec une gestion de l'auteur basic
- Création de la classe **Comment.php** ainsi que de la classe **CommentDAO.php**.
- Optimisation du code au niveau du DAO en créant un fichier *DAO.php*.
- Ajout de la méthode **find()** dans la classe *EpisodeDAO.php* afin de pouvoir faire le lien entre les commentaires.
- Optimisation de nos vues en créant un fichier *layout.html.twig*.
- Note : *Plutôt que de définir directement le lien href au niveau du titre de la barre de navigation, on utilise une fonction nommée **path()** qui permet de générer une URL dans un template. Pour pouvoir utiliser cette fonction, il faudra que toutes les routes de l'application portent un nom.*.
- Modification du fichier *app.php* pour ajouter le service d'acces aux commentaires.
- Modification du fichier *routes.php* pour ajouter la nouvelle route vers l'episode et ses commentaires.

___________________________________________________________

## 9-1 Commit : Saisie simple d'un commentaire sur un Episode

Ce commit contient :
- Ajout des composants nécessaires au bon fonctionnement de notre objet formulaire
**(composer.json)**
- Création du fichier **CommentType.php** dans *SRC\Form\Type* qui permettra de gérer le formulaire de saisie d'un commentaire.
- Ajout de la méthode **save()** dans notre class **CommentDAO** avec récupération du Pseudo par la variable session.
- Ajout des fournisseurs de services dans le fichier **app.php** correspondant aux composants nouvellement chargés.
- Modification du fichier routes.php pour créer le formulaire d'ajout d'un commentaire avant la génération de la vue.
- Modification de la vue **episode.html.twig** pour intégrer le formulaire.
- Ajustement visuel avec ajout de CSS et de balises BootStrap.
- Ajout de l'extension Text de twig permettant en autre d'utiliser la fonction truncate.
