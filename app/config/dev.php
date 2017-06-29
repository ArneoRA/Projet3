<?php

// Test avec une connexion en local base blogjf Commentaire basic
  $app['db.options'] = array(
    'driver'  =>'pdo_mysql',
    'charset' =>'utf8',
    'host'    =>'127.0.0.1', // Adresse ip obligatoire pour que PHPUnit fonctionne
    'port'    =>'3306',
    'dbname'  =>'blogjfbasic',
    'user'    =>'php',
    'password'=>'1234',
  );

// enable the debug mode
$app['debug'] = true;
