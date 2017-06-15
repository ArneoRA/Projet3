<?php
// Base sur le serveur 1and1
  // $app['db.options'] = array(
  // 'driver'  =>'pdo_mysql',
  // 'charset' =>'utf8',
  // 'host'    =>'db684093681.db.1and1.com',
  // 'port'    =>'3306',
  // 'dbname'  =>'db684093681',
  // 'user'    =>'dbo684093681',
  // 'password'=>'Projet3Blog',
  // );


// Test avec une connexion en local base blogjf Commentaire basic
  $app['db.options'] = array(
    'driver'  =>'pdo_mysql',
    'charset' =>'utf8',
    'host'    =>'localhost',
    'port'    =>'3306',
    'dbname'  =>'blogjfbasic',
    'user'    =>'php',
    'password'=>'1234',
  );

// Test avec une connexion en local base blogjf Utilisateur enregistré
  // $app['db.options'] = array(
  //   'driver'  =>'pdo_mysql',
  //   'charset' =>'utf8',
  //   'host'    =>'localhost',
  //   'port'    =>'3306',
  //   'dbname'  =>'blogjf',
  //   'user'    =>'php',
  //   'password'=>'1234',
  // );
