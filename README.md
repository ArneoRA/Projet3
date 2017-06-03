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

## 9eme Commit : Gestion de la sécurité et ajustement de l'affichage

Ce commit contient :
- Ajout d'une extension de twig Text : **twig/extensions** afin de pouvoir en autre utiliser les fonctions comme truncate.
- Ajustement de la police pour le contenu des épisodes.
- Gestion de la sécurité : Création d'une table **utilisateurs**, de la classe **User** et de la classe DAO **UserDAO**.
- Modification de la classe **CommentDAO** afin d'intégrer la classe User.
- Ajout dans *composer.json* la dépendance à *symfony/security*.
- Modification du fichier **app.php** pour ajouter les fournisseurs de service pour la gestion de la sécurité
- Modification du fichier **routes.app** pour créer la route vers la page **login**.
- Création de la vue **login.html.twig** associée à la route d'authentification.
- Modification de la vue **episode.html.twig** pour obtenir un affichage adapté à la présence d'un utilisateur connecté.
- Modification de la vue **layout.html.twig** pour ajouter à la barre de navigation un menu déroulant associé à l'éventuel utilisateur authnetifié.


__________________________________________________________

## 10eme Commit : Ajout de commentaire à un Episode

Ce commit contient :
- Modification du fichier **composer.json** pour ajouter les composants symfony **form** / **translation** / **config**.
Le composant **form** regroupe les services de gestion des formulaires. Le composant **translation** offre des services de traduction nécessaires pour utiliser le composant **form**. Le composantconfig est également nécessaire au bon fonctionnement de **form**.
- Modélisation du formulaire commentaire sous forme d'objet. (**SRC/FORM/TYPE**), nom du fichier **CommentType.php**.
- Ajout de la méthode **save()** dans la classe **CommentDAP**.
- Modification du controleur app.php pour ajouter les nouveaux fournisseurs de services
-- FormServiceProvider
-- LocaleServiceProvider
-- TranslationServiceProvider
- Modification du fichier **routes.php** pour créer le formulaire d'ajout d'un commentaire avant de générer la vue qui affiche le détail sur l'épisode.
- Modification de la vue **episode.html.twig** pour afficher le formulaire créé.


__________________________________________________________

## 11eme Commit : Création du BackOffice - 1ere version

Ce commit contient :
- Modification du fichier **app.php** pour soummettre l'accés au backOffice pour les users possédant le role **ROLE_ADMIN**.
- Modification de la vue **layout.html.twig** pour signaler visuellement à l'administrateur qu'il peut accéder au BackOffice.
- Création de la page d'accueil du BackOffice - modifiation du fichier **routes.php**
- Ajout de la méthode **findAll()** dans la classe **CommentDAO**.
- Ajout du composant symfony/validator dans le fichier composer.json et modification du fichier **app.php**.
- Création de la vue **admin.html.twig**.
- Gestion des episodes (objet formulaire) **EpisodeType**. + Création de la vue **episode_form.html.twig**.
-- Ajout des méthodes **save()** et **delete()** *(A voir si ca sera utile si on désactive le bouton suppression une fois que l'épisode est validé)*.
- Modification du fichier **routes.php** pour créer les routes de création, modification et suppression d'un episode.
- Gestion des commentaires : Création de la vue **comment_form.html.twig**.
- Modification de la vue **admin.html.twig** pour y ajouter le code permettant d'afficher les commentaires et les actions associées.
- Modification de la classe **CommentDAO** pour y ajouter la méthode de recherche d'un commentaire ainsique sa suppression.
- Modification des controleurs fichier **routes.php** pour ajouter les routes de modification et de suppression des commentaires.
- Gestion des utilisateurs : Création de l'objet formulaire **UserType.php** dans le répertoire *SRC\Form\Type*
- Création de la vue associé à ce formulaire : **user_form.html.twig**.
- Modifcation de la vue admin pour ajouter le code lié à la gestion des utilisateurs.
- Ajout des methodes save et delete de la classe UserDAO
- Modification du fichier routes.php pour la gestion des utilisateurs


__________________________________________________________

## 12eme Commit : Mise à jour fichiers UML - Episode

Ce commit contient :
- Mise à jour du fichier UML au niveau de la gestion des Episodes

__________________________________________________________

## 13eme Commit : Modification visuel : CSS, Vues

Ce commit contient :
- Mise à jour du fichier CSS pour intégrer la couverture du livre
- Ajustement au niveau de l'orientation des vues
