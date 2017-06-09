<?php

use Symfony\Component\HttpFoundation\Request;
use Projet3\Domain\Comment;
use Projet3\Domain\Episode;
use Projet3\Domain\User;
use Projet3\Form\Type\CommentType;
use Projet3\Form\Type\EpisodeType;
use Projet3\Form\Type\UserType;

  // Home page
  $app->get('/', function () use ($app) {
      $episodes = $app['dao.episode']->findAll();
      return $app['twig']->render('index.html.twig', array('episodes' => $episodes));
  })->bind('home');

  /// Episode details with comments
  $app->match('/episode/{id}', function ($id, Request $request) use ($app) {
      $episode = $app['dao.episode']->find($id);
      $commentFormView = null;
      if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
          // A user is fully authenticated : he can add comments
          $comment = new Comment();
          $comment->setEpisode($episode);
          $user = $app['user'];
          $comment->setAuthor($user);
          $commentForm = $app['form.factory']->create(CommentType::class, $comment);
          $commentForm->handleRequest($request);
          if ($commentForm->isSubmitted() && $commentForm->isValid()) {
              $app['dao.comment']->save($comment);
              $app['session']->getFlashBag()->add('success', 'Votre commentaire a été correctement ajouté.');
          }
          $commentFormView = $commentForm->createView();
      }
      $comments = $app['dao.comment']->findAllByEpisode($id);

      return $app['twig']->render('episode.html.twig', array(
          'episode' => $episode,
          'comments' => $comments,
          'commentForm' => $commentFormView));
  })->bind('episode');



  // Signal a spam comment
  $app->match('/episode/{id}/spam', function($id, Request $request) use ($app) {
      $comment = $app['dao.comment']->find($id);
      $comment = $app['dao.comment']->spamC($comment);
      $episode = $app['dao.episode']->findComm($id);
      $commentFormView = null;
      if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
          // A user is fully authenticated : he can add comments
          $comment = new Comment();
          $comment->setEpisode($episode);
          $user = $app['user'];
          $comment->setAuthor($user);
          $commentForm = $app['form.factory']->create(CommentType::class, $comment);
          $commentForm->handleRequest($request);
          if ($commentForm->isSubmitted() && $commentForm->isValid()) {
              $app['dao.comment']->save($comment);
              $app['session']->getFlashBag()->add('success', 'Votre commentaire a été correctement ajouté.');
          }
          $commentFormView = $commentForm->createView();
      }
      $comments = $app['dao.comment']->findAllByEpisode($episode->getId());

      return $app['twig']->render('episode.html.twig', array(
          'episode' => $episode,
          'comments' => $comments,
          'commentForm' => $commentFormView));
  })->bind('comment_spam');





  // Add a new episode
  $app->match('/admin/episode/add', function(Request $request) use ($app) {
      $episode = new Episode();
      $episodeForm = $app['form.factory']->create(EpisodeType::class, $episode);
      $episodeForm->handleRequest($request);
      if ($episodeForm->isSubmitted() && $episodeForm->isValid()) {
          $app['dao.episode']->save($episode);
          $app['session']->getFlashBag()->add('success', 'L\'Episode a été créé correctement.');
      }
      return $app['twig']->render('episode_form.html.twig', array(
          'title' => 'Nouvel episode',
          'episodeForm' => $episodeForm->createView()));
  })->bind('admin_episode_add');

  // Edit an existing episode
  $app->match('/admin/episode/{id}/edit', function($id, Request $request) use ($app) {
      $episode = $app['dao.episode']->find($id);
      $episodeForm = $app['form.factory']->create(EpisodeType::class, $episode);
      $episodeForm->handleRequest($request);
      if ($episodeForm->isSubmitted() && $episodeForm->isValid()) {
          $app['dao.episode']->save($episode);
          $app['session']->getFlashBag()->add('success', 'L\'Episode a été mis à jour avec succès.');
      }
      return $app['twig']->render('episode_form.html.twig', array(
          'title' => 'Ajouter un episode',
          'episodeForm' => $episodeForm->createView()));
  })->bind('admin_episode_edit');

  // Remove an episode
  $app->get('/admin/episode/{id}/delete', function($id, Request $request) use ($app) {
      // Delete all associated comments
      $app['dao.comment']->deleteAllByEpisode($id);
      // Delete the episode
      $app['dao.episode']->delete($id);
      $app['session']->getFlashBag()->add('success', 'L\'episode a correctement été supprimé.');
      // Redirect to admin home page
      return $app->redirect($app['url_generator']->generate('admin'));
  })->bind('admin_episode_delete');

  // Login form
  $app->get('/login', function(Request $request) use ($app) {
      return $app['twig']->render('login.html.twig', array(
          'error'         => $app['security.last_error']($request),
          'last_username' => $app['session']->get('_security.last_username'),
      ));
  })->bind('login');

  // Admin home page
  $app->get('/admin', function() use ($app) {
      $episodes = $app['dao.episode']->findAll();
      $comments = $app['dao.comment']->findAll();
      $users = $app['dao.user']->findAll();
      return $app['twig']->render('admin.html.twig', array(
          'episodes' => $episodes,
          'comments' => $comments,
          'users' => $users));
  })->bind('admin');


  // Edit an existing comment
  $app->match('/admin/comment/{id}/edit', function($id, Request $request) use ($app) {
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
  })->bind('admin_comment_edit');


  // Remove a comment
  $app->get('/admin/comment/{id}/delete', function($id, Request $request) use ($app) {
      $app['dao.comment']->delete($id);
      $app['session']->getFlashBag()->add('success', 'Le commentaire a été correctement supprimé.');
      // Redirect to admin home page
      return $app->redirect($app['url_generator']->generate('admin'));
  })->bind('admin_comment_delete');


  // Add a user
  $app->match('/admin/user/add', function(Request $request) use ($app) {
      $user = new User();
      $userForm = $app['form.factory']->create(UserType::class, $user);
      $userForm->handleRequest($request);
      if ($userForm->isSubmitted() && $userForm->isValid()) {
          // generate a random salt value
          $salt = substr(md5(time()), 0, 23);
          $user->setSalt($salt);
          $plainPassword = $user->getPassword();
          // find the default encoder
          $encoder = $app['security.encoder.bcrypt'];
          // compute the encoded password
          $password = $encoder->encodePassword($plainPassword, $user->getSalt());
          $user->setPassword($password);
          $app['dao.user']->save($user);
          $app['session']->getFlashBag()->add('success', 'The user was successfully created.');
      }
      return $app['twig']->render('user_form.html.twig', array(
          'title' => 'New user',
          'userForm' => $userForm->createView()));
  })->bind('admin_user_add');

  // Edit an existing user
  $app->match('/admin/user/{id}/edit', function($id, Request $request) use ($app) {
      $user = $app['dao.user']->find($id);
      $userForm = $app['form.factory']->create(UserType::class, $user);
      $userForm->handleRequest($request);
      if ($userForm->isSubmitted() && $userForm->isValid()) {
          $plainPassword = $user->getPassword();
          // find the encoder for the user
          $encoder = $app['security.encoder_factory']->getEncoder($user);
          // compute the encoded password
          $password = $encoder->encodePassword($plainPassword, $user->getSalt());
          $user->setPassword($password);
          $app['dao.user']->save($user);
          $app['session']->getFlashBag()->add('success', 'The user was successfully updated.');
      }
      return $app['twig']->render('user_form.html.twig', array(
          'title' => 'Edit user',
          'userForm' => $userForm->createView()));
  })->bind('admin_user_edit');

  // Remove a user
  $app->get('/admin/user/{id}/delete', function($id, Request $request) use ($app) {
      // Delete all associated comments
      $app['dao.comment']->deleteAllByUser($id);
      // Delete the user
      $app['dao.user']->delete($id);
      $app['session']->getFlashBag()->add('success', 'The user was successfully removed.');
      // Redirect to admin home page
      return $app->redirect($app['url_generator']->generate('admin'));
  })->bind('admin_user_delete');






?>
