<?php

// Permet de configurer Silex pour gérer les erreurs PHP
// pour qu'elles soient plus explicites
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});

$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));

$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());

$app->register(new Silex\Provider\SessionServiceProvider());

// Register services.
$app['dao.episode'] = function ($app) {
    return new Projet3\DAO\EpisodeDAO($app['db']);
};

$app['dao.comment'] = function ($app) {
    $commentDAO = new Projet3\DAO\CommentDAO($app['db']);
    $commentDAO->setEpisodeDAO($app['dao.episode']);
    return $commentDAO;
};
