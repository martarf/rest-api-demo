<?php

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'dbname'   => 'antevenio',
        'host'     => 'localhost',
        'user'     => 'antevenio',
        'password' => 'antevenio',
        'charset'       => 'utf8',
        'driverOptions' => array(1002 => 'SET NAMES utf8',),
    ),
));

require __DIR__.'/config.php';