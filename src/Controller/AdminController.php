<?php

  namespace Projet3\Controller;

  use Silex\Application;
  use Symfony\Component\HttpFoundation\Request;
  use Projet3\Domain\Comment;
  use Projet3\Domain\Episode;
  use Projet3\Domain\User;
  use Projet3\Form\Type\CommentType;
  use Projet3\Form\Type\EpisodeType;
  use Projet3\Form\Type\UserType;

  class Admincontroller {

    /**
     * Controleur Admin Page
     *
     * @param Application $app Application Silex
     */
    public function indexAction(Application $app){
      $episodes = $app['dao.episode']->findAll();
      $comments = $app['dao.comment']->findAll();
      $users = $app['dao.user']->findAll();
      return $app['twig']->render('admin.html.twig', array(
          'episodes' => $episodes,
          'comments' => $comments,
          'users' => $users));
    }

    /**
     * Controleur pour ajouter un episode
     *
     * @param Application $app Application Silex
     * @param Request $request Requete transmise
     */
    public function addEpisodeAction(Request $request, Application $app){
      $episode = new Episode();
      $episodeForm = $app['form.factory']->create(EpisodeType::class, $episode);
      $episodeForm->handleRequest($request);
      if ($episodeForm->isSubmitted() && $episodeForm->isValid()) {
          $app['dao.episode']->save($episode, $app);
          $app['session']->getFlashBag()->add('success', 'L\'Episode a été créé correctement.');
      }
      return $app['twig']->render('episode_form.html.twig', array(
          'title' => 'Nouvel episode',
          'episodeForm' => $episodeForm->createView()));
    }

    /**
     * Controleur pour MAJ un episode
     *
     * @param int $id Identifiant de l'episode
     * @param Request $request Requete transmise
     * @param Application $app Application Silex
     */
    public function editEpisodeAction($id, Request $request, Application $app){
      $episode = $app['dao.episode']->find($id);
      $episodeForm = $app['form.factory']->create(EpisodeType::class, $episode);
      $episodeForm->handleRequest($request);
      if ($episodeForm->isSubmitted() && $episodeForm->isValid()) {
          $app['dao.episode']->save($episode, $app);
          $app['session']->getFlashBag()->add('success', 'L\'Episode a été mis à jour avec succès.');
      }
      return $app['twig']->render('episode_form.html.twig', array(
          'title' => 'Ajouter un episode',
          'episodeForm' => $episodeForm->createView()));
    }

    /**
     * Controleur pour supprimer un episode
     *
     * @param int $id Identifiant de l'episode
     * @param Application $app Application Silex
     */
    public function deleteEpisodeAction($id, Application $app){
      // Delete all associated comments
      $app['dao.comment']->deleteAllByEpisode($id);
      // Delete the episode
      $app['dao.episode']->delete($id);
      $app['session']->getFlashBag()->add('success', 'L\'episode a correctement été supprimé.');
      // Redirect to admin home page
      return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Controleur pour MAJ d'un commentaire
     *
     * @param int $id Identifiant du commentaire
     * @param Request $request Requete transmise
     * @param Application $app Application Silex
     */
    public function editCommentAction ($id, Request $request, Application $app){
      $comment = $app['dao.comment']->find($id);
      $commentForm = $app['form.factory']->create(CommentType::class, $comment);
      $commentForm->handleRequest($request);
      if ($commentForm->isSubmitted() && $commentForm->isValid()) {
          $app['dao.comment']->save($comment);
          $app['session']->getFlashBag()->add('success', 'Le commentaire a été correctement mis à jour.');
      }
      return $app['twig']->render('comment_form.html.twig', array(
          'title' => 'Edit comment',
          'commentForm' => $commentForm->createView()));
    }

    /**
     * Controleur pour supprimer un commentaire
     *
     * @param int $id Identifiant du commentaire à supprimer
     * @param Application $app Application Silex
     */
    public function deleteCommentAction($id, Application $app){
      $app['dao.comment']->delete($id);
      $app['session']->getFlashBag()->add('success', 'Le commentaire a été correctement supprimé.');
      // Redirect to admin home page
      return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Controleur pour ajouter un utilisateur
     *
     * @param Request $request Requete transmise
     * @param Application $app Application Silex
     */
    public function addUserAction(Request $request, Application $app){
      $user = new User();
      $userForm = $app['form.factory']->create(UserType::class, $user);
      $userForm->handleRequest($request);
      if ($userForm->isSubmitted() && $userForm->isValid()) {
          // Genere une valeur aléatoire pour le "salage" salt
          $salt = substr(md5(time()), 0, 23);
          $user->setSalt($salt);
          $plainPassword = $user->getPassword();
          // Trouve l'encoder par défaut
          $encoder = $app['security.encoder.bcrypt'];
          // Genere le mot de passe avec le salage
          $password = $encoder->encodePassword($plainPassword, $user->getSalt());
          $user->setPassword($password);
          $app['dao.user']->save($user);
          $app['session']->getFlashBag()->add('success', 'L\'utilisateur a été ajouté avec succès.');
      }
      return $app['twig']->render('user_form.html.twig', array(
          'title' => 'Nouvel Utilisateur',
          'userForm' => $userForm->createView()));
    }

    /**
     * Controleur pour MAJ un Utilisateur
     *
     * @param int $id Identifiant de l'utilisateur
     * @param Request $request Requete transmise
     * @param Application $app Application Silex
     */
    public function editUserAction($id, Request $request, Application $app){
      $user = $app['dao.user']->find($id);
      $userForm = $app['form.factory']->create(UserType::class, $user);
      $userForm->handleRequest($request);
      if ($userForm->isSubmitted() && $userForm->isValid()) {
          $plainPassword = $user->getPassword();
          // Trouve l'encoder pour l'utilisateur
          $encoder = $app['security.encoder_factory']->getEncoder($user);
          // Genere le mot de passe
          $password = $encoder->encodePassword($plainPassword, $user->getSalt());
          $user->setPassword($password);
          $app['dao.user']->save($user);
          $app['session']->getFlashBag()->add('success', 'L\'utilisateur a été mise à jour avec succès.');
      }
      return $app['twig']->render('user_form.html.twig', array(
          'title' => 'Edit user',
          'userForm' => $userForm->createView()));
    }

    /**
     * Controleur pour supprimer un utilisateur
     *
     * @param int $id Identifiant de l'utilisateur
     * @param Application $app Application Silex
     */
    public function deleteUserAction ($id, Application $app){
      // Supprime l'utilisateur
      $app['dao.user']->delete($id);
      $app['session']->getFlashBag()->add('success', 'L\'utilisateur a été supprimé correctement.');
      // Redirige vers la home Page Admin
      return $app->redirect($app['url_generator']->generate('admin'));
    }

  }

?>
