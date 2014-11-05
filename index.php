<?php

define('PS', '/');
define('NS', '\\');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', __DIR__ );
define('SRC_PATH', ROOT_PATH.DS.'src'.DS);
define('APP_PATH', SRC_PATH.'App'.DS);

require_once __DIR__.DS.'vendor'.DS.'autoload.php';

$app = new Silex\Application();

require APP_PATH.'Config'.DS.'app.php';
require SRC_PATH.'app.php';

$app->run();