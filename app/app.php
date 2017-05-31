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

// Register services.
$app['dao.episode'] = function ($app) {
    return new Projet3\DAO\EpisodeDAO($app['db']);
};