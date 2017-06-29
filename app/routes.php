<?php

// ======= FRONT CONTROLLER ============= /
// === Home page
  $app->get('/', "Projet3\Controller\HomeController::indexAction")
  ->bind('home');

// === Détail de l'episode avec les commentaires
  $app->match('/episode/{id}', "Projet3\Controller\HomeController::episodeAction")
  ->bind('episode');

// === Formulaire de connexion (Authentification)
  $app->get('/login', "Projet3\Controller\HomeController::loginAction")
  ->bind('login');

// === Répondre à un commentaire
  $app->match('/episode/{id}/response/add', "Projet3\Controller\HomeController::repCommAction")
  ->bind('response_add');



// ======= BACK CONTROLLER ============= /
// === Page d'administration
  $app->get('/admin', "Projet3\Controller\AdminController::indexAction")
  ->bind('admin');

// === Partie episode ===
// === Ajout
  $app->match('/admin/episode/add', "Projet3\Controller\AdminController::addEpisodeAction")
  ->bind('admin_episode_add');
// ==== Mise à jour
  $app->match('/admin/episode/{id}/edit', "Projet3\Controller\AdminController::editEpisodeAction")
  ->bind('admin_episode_edit');
// === Suppression
  $app->get('/admin/episode/{id}/delete', "Projet3\Controller\AdminController::deleteEpisodeAction")
  ->bind('admin_episode_delete');


// === Partie Commentaire ===
// === Mise à jour
  $app->match('/admin/comment/{id}/edit', "Projet3\Controller\AdminController::editCommentAction")
  ->bind('admin_comment_edit');
// === Suppression
  $app->get('/admin/comment/{id}/delete', "Projet3\Controller\AdminController::deleteCommentAction")
  ->bind('admin_comment_delete');


// === Partie Utilisateur ===
// === Ajout
  $app->match('/admin/user/add', "Projet3\Controller\AdminController::addUserAction")
  ->bind('admin_user_add');
// === Mise à jour
  $app->match('/admin/user/{id}/edit', "Projet3\Controller\AdminController::editUserAction")
  ->bind('admin_user_edit');
// === Suppression
  $app->get('/admin/user/{id}/delete', "Projet3\Controller\AdminController::deleteUserAction")
  ->bind('admin_user_delete');



// ======= API CONTROLLER ============= /
// === Signaler un commentaire (Spam)
$app->match('/api/comment/{id}/spam', "Projet3\Controller\ApiController::signalCommentAction");



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


?>
