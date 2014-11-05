<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use Silex\Provider\MonologServiceProvider;
use App\Provider\ControllerProvider;
use Ruckuus\Silex\ActiveRecordServiceProvider;

$app->register(new ActiveRecordServiceProvider, $app->raw('config.activerecord'));
$app->register(new MonologServiceProvider, $app->raw('config.monolog'));

$app->mount('/', new ControllerProvider);

//CORS
$app->before(function (Request $request) {
    if ($request->getMethod() === "OPTIONS") {
        $response = new Response();
        $response->headers->set("Access-Control-Allow-Origin","*");
        $response->headers->set("Access-Control-Allow-Methods","GET,POST,PUT,DELETE,OPTIONS");
        $response->headers->set("Access-Control-Allow-Headers","Content-Type");
        $response->setStatusCode(200);
        return $response->send();
    }
}, Application::EARLY_EVENT);

$app->after(function (Request $request, Response $response) {
    $response->headers->set("Access-Control-Allow-Origin","*");
    $response->headers->set("Access-Control-Allow-Methods","GET,POST,PUT,DELETE,OPTIONS");
});

$app->error(function (\Exception $e, $code) use ($app) {
    $app['monolog']->addError($e->getMessage());
    $app['monolog']->addError($e->getTraceAsString());

    return new JsonResponse(array(
        "statusCode" => $code,
        "message" => $e->getMessage(),
        "stacktrace" => $e->getTraceAsString()
    ));
});