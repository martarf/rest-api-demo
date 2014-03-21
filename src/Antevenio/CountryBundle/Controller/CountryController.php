<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$countryController = $app['controllers_factory'];

/**
 * Get all available countries
 */
$countryController->get('/countries', function () use ($app){

    $countries      = $app['db.orm.em']->getRepository('\Antevenio\Entity\Country')->getAllCountries();
    return new Response(json_encode($countries),200,array('Content-Type'=>'application/json'));

});

/**
 * Get a single country
 */
$countryController->get('/countries/{id}', function (Request $request) use ($app){

    if(!$id = $request->get('id'))
    {
        return new Response('Missing parameter',400);
    }

    $country = $app['db.orm.em']->getRepository('\Antevenio\Entity\Country')->getCountryById($id);

    if(!$country)
    {
        return new Response('Not Found',404);
    }

    return new Response(json_encode($country),200,array('Content-Type'=>'application/json'));

});

/**
 * Add a new country
 */
$countryController->post('/countries', function (Request $request) use ($app){

    $data = $request->get('country');
    if(!isset($data['name']) || !isset($data['code']))
    {
        return new Response('Missing parameter',400);
    }

    $country = new \Antevenio\Entity\Country();
    $country->setName($data['name']);
    $country->setCode($data['code']);
    $app['db.orm.em']->persist($country);
    $app['db.orm.em']->flush();

    return $app->redirect('/countries/'.$country->getId(), 201);
});

/**
 * Update an existing country
 */
$countryController->put('/countries', function (Request $request) use ($app){

    $data = $request->get('country');
    if(!isset($data['name']) || !isset($data['code']) || !isset($data['id']))
    {
        return new Response('Missing parameter',400);
    }
    $country = $app['db.orm.em']->getRepository('\Antevenio\Entity\Country')->find($data['id']);
    if(!$country instanceof \Antevenio\Entity\Country)
    {
        return new Response('Not Found',404);
    }

    $country->setName($data['name']);
    $country->setCode($data['code']);
    $app['db.orm.em']->persist($country);
    $app['db.orm.em']->flush();

    $country = $app['db.orm.em']->getRepository('\Antevenio\Entity\Country')->getCountryById($data['id']);

    return new Response(json_encode($country),204,array('Content-Type'=>'application/json'));

});

/**
 * Delete an existing country
 */
$countryController->delete('/countries', function (Request $request) use ($app){

    if(!$id = $request->get('id'))
    {
        return new Response('Missing parameter',400);
    }

    $country = $app['db.orm.em']->getRepository('\Antevenio\Entity\Country')->find($id);
    if(!$country instanceof \Antevenio\Entity\Country)
    {
        return new Response('Not Found',404);
    }
    $app['db.orm.em']->remove($country);
    $app['db.orm.em']->flush();

    return new Response('ok',200,array('Content-Type'=>'application/json'));

});


return $countryController;
