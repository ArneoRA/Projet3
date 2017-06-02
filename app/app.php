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
    // Nous modifions la configuration du pare-feu pour définir une hiérarchie entre ROLE_ADMIN et ROLE_USER...
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
        // Puis pour protéger spécifiquement la zone/admin.
    ),
    'security.access_rules' => array(
            array('^/admin', 'ROLE_ADMIN'),
    ),
  // Ce service fournit un moyen de gérer les utilisateurs en terme de connexion sécurisée
));
// Fournisseur de services pour le formulaire et d'autres services associés
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());

// Fournisseur de services pour tester et valider les champs de nos formulaires
$app->register(new Silex\Provider\ValidatorServiceProvider());

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
