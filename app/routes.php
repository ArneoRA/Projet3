<?php

use Symfony\Component\HttpFoundation\Request;
use Projet3\Domain\Comment;
use Projet3\Domain\Episode;
use Projet3\Domain\User;
use Projet3\Form\Type\CommentType;
use Projet3\Form\Type\EpisodeType;
use Projet3\Form\Type\UserType;

// =================================== FRONT CONTROLLER ========================================= /
// ================ Home page
  $app->get('/', function () use ($app) {
      $episodes = $app['dao.episode']->findAll();
      return $app['twig']->render('index.html.twig', array('episodes' => $episodes));
  })->bind('home');

// ================ Détail de l'episode avec les commentaires
  $app->match('/episode/{id}', function ($id, Request $request) use ($app) {
      $episode = $app['dao.episode']->find($id);
      $commentFormView = null;
      if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
          // Un utilisateur authentifié peut ajouter un commentaire
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
          // Réinitialisation du formulaire commentaire
          $comment = new Comment();
          $commentForm = $app['form.factory']->create(CommentType::class, $comment);
          $commentFormView = $commentForm->createView();
      }
      $comments = $app['dao.comment']->findAllByEpisode($id);

      return $app['twig']->render('episode.html.twig', array(
          'episode' => $episode,
          'comments' => $comments,
          'commentForm' => $commentFormView));
  })->bind('episode');

// ================ Répondre à un commentaire
  $app->match('/episode/{id}/response/add', function ($id, Request $request) use ($app) {
      $comment = $app['dao.comment']->find($id);
      $comment = $app['dao.comment']->save($comment);
      $episode = $app['dao.episode']->findComm($id);
      $comments = $app['dao.comment']->findAllByEpisode($id);
      // Réinitialisation du formulaire commentaire
      $comment = new Comment();
      $commentForm = $app['form.factory']->create(CommentType::class, $comment);

      return $app['twig']->render('episode.html.twig', array(
          'episode' => $episode,
          'comments' => $comments,
          'commentForm' => $commentForm->createView()));
  })->bind('response_add');


// ================ Signaler un commentaire (Spam)
  // $app->match('/episode/{id}/spam', function($id, Request $request) use ($app) {
  //     $comment = $app['dao.comment']->find($id);
  //     // error_log('Contenu de $comment avant lancement spamC : '. var_dump($comment));
  //     $comment = $app['dao.comment']->spamC($comment);
  //     $episode = $app['dao.episode']->findComm($id);
  //     $commentForm = null;
  //     // Création du Message Flash
  //     $app['session']->getFlashBag()->add('success', 'Le commentaire a bien été signalé à l\'administrateur du site.');
  //     // Préparation et regénération de la page Episode
  //     $comments = $app['dao.comment']->findAllByEpisode($episode->getId());
  //     return $app['twig']->render('episode.html.twig', array(
  //         'episode' => $episode,
  //         'comments' => $comments,
  //         'commentForm' => $commentForm));
  //     // // Redirection vers la page Episode
  //     // return $app->redirect($app['url_generator']->generate('home'));
  // })->bind('comment_spam');


// ================ Signaler un commentaire (Spam) par API
$app->post('/api/comment/{id}/spam', function($id, Request $request) use ($app) {
    $comment = $app['dao.comment']->find($id);
    $comment = $app['dao.comment']->spamC($comment);
    // On vérifie les paramétres de la requete
    error_log('Je passe par la bonne route');
    if (!$request->request->has('spam')) {
        error_log('Je suis dans le test de la présence de spam dans la request');
        return $app->json('Missing required parameter: spam', 400);
    }
    // $comment = $app['dao.comment']->find($id);
    // $comment = $app['dao.comment']->spamC($comment);
    return $app->json($comment, 200);  // 200 = OK
});



// ================ Formulaire de connexion (Authentification)
  $app->get('/login', function(Request $request) use ($app) {
      return $app['twig']->render('login.html.twig', array(
          'error'         => $app['security.last_error']($request),
          'last_username' => $app['session']->get('_security.last_username'),
      ));
  })->bind('login');

// =================================== BACK CONTROLLER ========================================= /
// ================ Page d'administration
  $app->get('/admin', function() use ($app) {
      $episodes = $app['dao.episode']->findAll();
      $comments = $app['dao.comment']->findAll();
      $users = $app['dao.user']->findAll();
      return $app['twig']->render('admin.html.twig', array(
          'episodes' => $episodes,
          'comments' => $comments,
          'users' => $users));
  })->bind('admin');


// ================ Ajouter un épisode
  $app->match('/admin/episode/add', function(Request $request) use ($app) {
      $episode = new Episode();
      $episodeForm = $app['form.factory']->create(EpisodeType::class, $episode);
      $episodeForm->handleRequest($request);

      if ($episodeForm->isSubmitted() && $episodeForm->isValid()) {
        // error_log('je passe dans le test');
          $app['dao.episode']->save($episode);
          $app['session']->getFlashBag()->add('success', 'L\'Episode a été créé correctement.');
      }
      // Réinitialisation du formulaire Episode
      $episode = new Episode();
      $episodeForm = $app['form.factory']->create(EpisodeType::class, $episode);
      // error_log('je suis hors du test');
      return $app['twig']->render('episode_form.html.twig', array(
          'title' => 'Nouvel episode',
          'episodeForm' => $episodeForm->createView()));
  })->bind('admin_episode_add');



// ================ Mise à jour d'un episode
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



// ================ Suppression d'un episode
  $app->get('/admin/episode/{id}/delete', function($id, Request $request) use ($app) {
      // Supprime les commentaires associés à l'episode
      $app['dao.comment']->deleteAllByEpisode($id);
      // Supprime l'episode
      $app['dao.episode']->delete($id);
      $app['session']->getFlashBag()->add('success', 'L\'episode a correctement été supprimé.');
      // Redirige vers la page Admin
      return $app->redirect($app['url_generator']->generate('admin'));
  })->bind('admin_episode_delete');


// ================ Mise à jour d'un commentaire
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


// ================ Suppression d'un commentaire
  $app->get('/admin/comment/{id}/delete', function($id, Request $request) use ($app) {
      $app['dao.comment']->delete($id);
      $app['session']->getFlashBag()->add('success', 'Le commentaire a été correctement supprimé.');
      // Redirige vers la page Admin
      return $app->redirect($app['url_generator']->generate('admin'));
  })->bind('admin_comment_delete');


// ================ Ajout d'un utilisateur
  $app->match('/admin/user/add', function(Request $request) use ($app) {
      $user = new User();
      $userForm = $app['form.factory']->create(UserType::class, $user);
      $userForm->handleRequest($request);
      if ($userForm->isSubmitted() && $userForm->isValid()) {
          // genere un salage (salt) aléatoire
          $salt = substr(md5(time()), 0, 23);
          $user->setSalt($salt);
          $plainPassword = $user->getPassword();
          // trouve l'encodeur par défaut
          $encoder = $app['security.encoder.bcrypt'];
          // génére le mot de passe codé
          $password = $encoder->encodePassword($plainPassword, $user->getSalt());
          $user->setPassword($password);
          $app['dao.user']->save($user);
          $app['session']->getFlashBag()->add('success', 'L\'utilisateur a été ajouté avec succès.');
      }
      // Réinitialisation du formulaire Utilisateur
      $user = new User();
      $userForm = $app['form.factory']->create(UserType::class, $user);

      return $app['twig']->render('user_form.html.twig', array(
          'title' => 'Nouvel Utilisateur',
          'userForm' => $userForm->createView()));
  })->bind('admin_user_add');

// ================ Mise à jour d'un utilisateur
  $app->match('/admin/user/{id}/edit', function($id, Request $request) use ($app) {
      $user = $app['dao.user']->find($id);
      $userForm = $app['form.factory']->create(UserType::class, $user);
      $userForm->handleRequest($request);
      if ($userForm->isSubmitted() && $userForm->isValid()) {
          $plainPassword = $user->getPassword();
          // trouve l'encodeur de l'utilisateur
          $encoder = $app['security.encoder_factory']->getEncoder($user);
          // génére le mot de passe codé
          $password = $encoder->encodePassword($plainPassword, $user->getSalt());
          $user->setPassword($password);
          $app['dao.user']->save($user);
          $app['session']->getFlashBag()->add('success', 'The user was successfully updated.');
      }
      return $app['twig']->render('user_form.html.twig', array(
          'title' => 'Edit user',
          'userForm' => $userForm->createView()));
  })->bind('admin_user_edit');

// ================ Suppression d'un utilisateur
  $app->get('/admin/user/{id}/delete', function($id, Request $request) use ($app) {
      // Supprime l'ensemble des commentaires associés
      $app['dao.comment']->deleteAllByUser($id);
      // Supprime l'utilisateur
      $app['dao.user']->delete($id);
      $app['session']->getFlashBag()->add('success', 'The user was successfully removed.');
      // Redirige vers la page Admin
      return $app->redirect($app['url_generator']->generate('admin'));
  })->bind('admin_user_delete');


?>
