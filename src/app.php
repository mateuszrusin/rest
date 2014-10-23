<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Silex\Application;
use Silex\Provider\MonologServiceProvider;
use Rest\Controller\ControllerProvider;
use Ruckuus\Silex\ActiveRecordServiceProvider;
use Silex\Provider\FacebookServiceProvider;

date_default_timezone_set('Europe/Warsaw');

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new ActiveRecordServiceProvider(), array(
    'ar.model_dir' => APP_PATH . 'Model',
    'ar.connections' =>  array ('development' => 'sqlite://storage/db/rest.db'),
    'ar.default_connection' => 'development'
));

$app->register(new MonologServiceProvider(), array(
    "monolog.logfile" => ROOT_PATH . "/storage/logs/" . date("Y-m-d") . ".log",
    "monolog.level" => $app["log.level"],
    "monolog.name" => "application"
));

//$app->error(function (\Exception $e, $code) use ($app) {
//    $app['monolog']->addError($e->getMessage());
//    $app['monolog']->addError($e->getTraceAsString());
//
//    return new JsonResponse(array(
//        "statusCode" => $code,
//        "message" => $e->getMessage(),
//        "stacktrace" => $e->getTraceAsString()
//    ));
//});

//$app->before(function (Request $request, Application $app) {
//    if ($request->query->count())
//        print_r($request);
//}, Application::EARLY_EVENT);

$app->mount('/', new ControllerProvider);

