<?php

use Symfony\Component\HttpFoundation\Request;

  // Home page
  $app->get('/', function () use ($app) {
      $episodes = $app['dao.episode']->findAll();
      return $app['twig']->render('index.html.twig', array('episodes' => $episodes));
  })->bind('home');

  // Episode details with comments
  $app->get('/episode/{id}', function ($id) use ($app) {
      $episode = $app['dao.episode']->find($id);
      $comments = $app['dao.comment']->findAllByEpisode($id);
      return $app['twig']->render('episode.html.twig', array('episode' => $episode, 'comments' => $comments));
  })->bind('episode');

  // Login form
  $app->get('/login', function(Request $request) use ($app) {
      return $app['twig']->render('login.html.twig', array(
          'error'         => $app['security.last_error']($request),
          'last_username' => $app['session']->get('_security.last_username'),
      ));
  })->bind('login');

?>
