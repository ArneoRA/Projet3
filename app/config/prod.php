<?php
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
