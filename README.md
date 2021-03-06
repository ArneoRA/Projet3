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

__________________________________________________________

## 14eme Commit : Signaler un Commentaire comme Spam

Ce commit contient :
- Ajustement de la vue **Index** pour intégrer un listing type panel "accordeon" de BootStrap
- Ajout des champs **niveau** et **spam** dans la table commentaire pour une meilleure gestion de ceux-ci.
- Ajustement de la vue **Episode** . en créant une vue-fille contenant uniquement l'affichage des commentaires (**subcomment.html.twig**).
- Ajout de l'attribut **spam** dans la classe **Comment.php**.
- Ajout de la méthode **spamC()** dans la classe **CommentDAO.php** pour incrémenter le champ **spam**.
- Ajout de la méthode **FindComm()** dans la classe **EpisodeDAO.php** pour rafraichir la page apres signalement d'un spam.
- Ajout d'une route spécifique **/episode/{id}/spam** dans le fichier **routes.php**.

__________________________________________________________

## 15eme Commit : Signaler un commentaire 2eme partie

Ce commit contient :
- Modification de l'administration pour afficher aussi les commentaires signalés "spammé"
- Modification de la méthode **FindAll()** afin de classer les commentaires dans l'ordre décroissant du champ **spam**.
- Correction d'un bug lors du rechargement de la vue episode apres avoir signalé un commentaire en spam.

__________________________________________________________

## 16eme Commit : Integration de TinyMCE dans l'ajout d'un Episode

Ce commit contient :
- Ajout du composant **TinyMCE** dans notre fichier composer.json
- Ajout d'une ligne de **script** dans notre vue principale **layout.html.twig**
- Initialisation de **tinymce_init** avec l'**ID de ma zone contenu** de l'episode
- Il reste encore un souci d'affichage le chemin vers **tinymce.min.js** n'est pas correct

__________________________________________________________

## 17eme Commit : Mise à jour des fichiers DB

Ce commit contient :
- Mise à jour des fichiers SQL DB

_________________________________________________________

## 18eme Commit : Modification visuel : Tableau Admin des commentaires

Ce commit contient :
- Ajout de la fonction tri des colonnes pour le tableau des commentaires dans la partie administration. Réalisé avec les datatables ( javascript et bootstrap 3).

________________________________________________________

## 19eme Commit : Implantation des commentaires imbriqués & TinyMCE

Ce commit contient :
-Modification des classes **Comment.php** et **CommentDAO.php** :
- **Comment.php** : Ajout d'un tableau **children** et de la méthode **addChildren($enreg)**.
- **CommentDAO.php** : Modification de la classe **findAllByEpisode()** afin qu'elle génére les commentaires imbriqués en fonction du champs **Parent_id**.
- Création de 2 nouvelles vues :
- **signaler.html.twig** : permettant de gérer le bouton Signaler(Spam) d'un commentaire
- **actions.html.twig** : permettant de gérer les boutons actions sur un commentaire.
- Ajustement de la vue **episode.html.twig** pour intégrer l'aspect imbriqué.
- Intégration du composant TinyMCE

________________________________________________________

## 20eme Commit : Ajustements visuels

Ce commit contient :
- Gestion du niveau de commentaire pour les boutons actions (Niveau 3 uniquement signaler)
- Ajout dans .igtignore du répertoire lib/tinymce
- Modification de l'image du Roman pour y intéger le nom de l'auteur et le titre du roman.

________________________________________________________

## 21eme Commit : Positionnement du footer

Ce commit contient :
- Footer fixé en bas de la page et mis en forme.
- Lien vers agence **Arnege** et vers **Github/projet3** mis en forme.

________________________________________________________

## 22eme Commit : Modifications UML,

Ce commit contient :
-Modification du fichier UML **Schema_UML_Classes.dia** (A titre d'information uniquement, n'a pas servi pour réalisé les classes du projet).

________________________________________________________

## 23eme Commit : Modifications Footer, visuels, reponse Commentaire

Ce commit contient :
- Modification des liens (réseaux sociaux)
- Ajustement de la marge top du footer
- Ajustement du champ **contenu** de l'écran ajouter un nouvel episode (**tinymce**).
- Amélioration de la route pour signaler un Spam.
- Ajout d'une réponse d'un commentaire :
- Modification de la classe **CommentDAO.php** en modifiant la méthode **save()** en y insérant :--'parent_id' =>$comment->getParentid(),--
- Ajout dans la classe **CommentType.php** (Class du formulaire Commentaire), de 2 champs **parentid et niveau de type hidden** permettant la récupération de 'information parent'.
- Modification de la vue episode.html.twig pour faciliter le traitement en JavaScript :
**Ajout d'un Id pour le formulaire et le champ parentid**
- Modification de la vue subcomment.html.twig pour faciliter le traitement en JavaScript :
**Ajout d'un id sur le détail du commentaire**
**Ajout d'un data-id sur le bouton servant à répondre ainsi qu'une classe reply**
- Création du fichier projet3.js contenant le traitement nécessaire pour afficher le formulaire du commentaire sous le commentaire de la réponse.

________________________________________________________

## 24eme Commit : Enregistrement d'un nouvel Episode avec Tinymce

Ce commit contient :
- Modification de la vue **episode_form.html.twig**
- Modifciation du fichier **Projet3.js**
- Modifcation de la classe **EpisodeDAO** afin qu'on sorte une exception si le contenu est vide.
- Modification de la vue index.html.twig afin qu'il affiche le contenu tinymce proprement.

________________________________________________________

## 25eme Commit : 1er Recettage

Ce commit contient :
- Intégration au final du code JS directement dans la vue avec ajout d'un block twig pour gérer ce JS au bon endroit.
- création d'une API pour gérer le signalement d'un commentaire spam sans passer par une route.
- Modification des fichiers : **subcomment**, **actions** et **signaler**.
- Correction de bug d'affichage des tableaux dynamiques DataTable. Fichiers impactés : **layout.html.twig**, **admin.html.twig**.
- Ajustement de l'aspect Responsive du site.
- Mise à jour des commentaires des classes.

________________________________________________________

## 26eme Commit : Modif proc Spam - Réorganisation des controleurs - Ajout tests fonctionnels

Ce commit contient :
- Modification de la procédure pour signaler un commentaire (spam).
- Création d'un répertoire **SRC/Controller** regroupant mes controleurs
- Création d'un fichier **HomeController.php** qui va gérer l'ensemble des routes en *frontend* sous forme de méthode de la classe **Homecontroller**.
- Création d'un fichier **AdminController.php** qui va gérer l'ensemble des routes en *backend* (administration) sous forme de méthode de la classe **Admincontroller**.
- Création d'un fichier **ApiController.php** qui contient la méthode permettant de *signaler un commentaire*. Elle aussi sous forme d'une méthode de la classe **ApiController**.
- Modification du fichier **routes.php** afin d'associer chaque route à sa méthode.
- **Ajout de tests fonctionnels** :
- [x] Installer le composant *PHPUnit* avec le fichier composer.json
- [x] Création de l'arborescence *tests/Tests* à la racine
- [x] Création dans ce répertoire du fichier *AppTest.php*
- [x] Création du fichier *phpunit.xml.dist* pour faciliter les tests.
- [x] Modification du fichier *dev.php* en utilisant l'adresse IP au lieu de localhost

## 27eme Commit : 2eme recettage

Ce commit contient :
- Correction de l'initialisation de TinyMCE dans le fichier episode_form.html.twig.
- Correction de la procédure de signalement d'un commentaire (suite bug du doublement du commentaire en cas de signalement). **projet3.js**

