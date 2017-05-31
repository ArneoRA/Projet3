<?php

  // Home page
  $app->get('/', function () use ($app) {
      $episodes = $app['dao.episode']->findAll();
      return $app['twig']->render('index.html.twig', array('episodes' => $episodes));
  });

?>
