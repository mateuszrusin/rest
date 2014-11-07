<?php
date_default_timezone_set('Europe/Warsaw');

$app['debug'] = true;
$app['log.level'] = Monolog\Logger::DEBUG;

// Monolog
$app['config.monolog'] = array(
    'monolog.logfile' => ROOT_PATH . '/storage/logs/' . date("Y-m-d") . '.log',
    'monolog.level' => $app['log.level'],
    'monolog.name' => 'application'
);

// Active Record
$app['config.activerecord'] = array(
    'ar.model_dir' => APP_PATH . 'Model',
    'ar.connections' =>  array ('development' => 'sqlite://storage/db/app.db'),
    'ar.default_connection' => 'development'
);
