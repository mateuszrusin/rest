<?php

namespace Rest\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Rest\Controller\Controller;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function() {
            return Controller::run();
        });

        $controllers->post('/{controller}', function (Request $request, $controller) {
            return Controller::factory($controller)->create($request);
        })->assert('controller', '[a-z]+');

        $controllers->get('/{controller}', function ($controller) {
            return Controller::factory($controller)->read();
        });

        $controllers->get('/{controller}/{id}', function ($controller, $id) {
            return Controller::factory($controller)->one($id);
        });

        $controllers->put('/{controller}/{id}', function (Request $request, $controller, $id) {
            return Controller::factory($controller)->update($id, $request);
        });

        $controllers->delete('/{controller}/{id}', function ($controller, $id) {
            return Controller::factory($controller)->delete($id);
        });

        return $controllers;
    }
}