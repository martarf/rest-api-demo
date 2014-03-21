<?php

ini_set('display_errors', 1);

require_once __DIR__.'/../app/bootstrap.php';

$app = new Silex\Application();
$app['debug'] = true;
require __DIR__.'/../app/config/dev.php';
require __DIR__.'/../app/controller.php';

return $app;
