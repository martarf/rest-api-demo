<?php

use \Symfony\Component\HttpFoundation\Response;

$app->get('/', function () {
    return "Welcome To Antevenio Country demo-API!";
});

$app->mount('/api/v1', include __DIR__.'/../src/Antevenio/CountryBundle/Controller/CountryController.php');

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new Response($message, $code);
});

return $app;
