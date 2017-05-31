<?php
  // $app['db.options'] = array(
  // 'driver'  =>'pdo_mysql',
  // 'charset' =>'utf8',
  // 'host'    =>'db684093681.db.1and1.com',
  // 'port'    =>'3306',
  // 'dbname'  =>'db684093681',
  // 'user'    =>'dbo684093681',
  // 'password'=>'Projet3Blog',
  // );


// Test sur une autre base de donnée
// $app['db.options'] = array(
// 'driver'  =>'pdo_mysql',
// 'charset' =>'utf8',
// 'host'    =>'db681537259.db.1and1.com',
// 'port'    =>'3306',
// 'dbname'  =>'db681537259',
// 'user'    =>'dbo681537259',
// 'password'=>'A_rx280701',
// );


// Test avec une connexion en local
  $app['db.options'] = array(
    'driver'  =>'pdo_mysql',
    'charset' =>'utf8',
    'host'    =>'localhost',
    'port'    =>'3306',
    'dbname'  =>'blogjf',
    'user'    =>'php',
    'password'=>'1234',
  );

