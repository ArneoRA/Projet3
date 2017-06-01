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
// Fournisseur de service pour l'extension Text de Twig et ainsi utiliser la fonction truncate
$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});
// Fournisseur de service pour faciliter la mise en forme Fichier CSS, BootStrap, JS
$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));
// Fournisseur de service pour la gestion de sécurité
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => function () use ($app) {
                return new Projet3\DAO\UserDAO($app['db']);
            },
        ),
    ),
));

// Register services Episode / User / Comment
$app['dao.episode'] = function ($app) {
    return new Projet3\DAO\EpisodeDAO($app['db']);
};

$app['dao.user'] = function ($app) {
    return new Projet3\DAO\UserDAO($app['db']);

};
$app['dao.comment'] = function ($app) {
    $commentDAO = new Projet3\DAO\CommentDAO($app['db']);
    $commentDAO->setEpisodeDAO($app['dao.episode']);
    $commentDAO->setUserDAO($app['dao.user']);
    return $commentDAO;
};
