<?php

require_once __DIR__.'/../app/bootstrap.php';

$app = new Silex\Application();

require __DIR__.'/../app/config/prod.php';
require __DIR__.'/../app/controller.php';

return $app;
