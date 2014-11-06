<?php

namespace App;

use App\Model\Model;
use App\DataManager;
use App\CRUDController;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class ControllerProvider implements ControllerProviderInterface
{
    /**
     * @param Application $app
     *
     * @return \Silex\ControllerCollection
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->post('/{controller}', function (Request $request, $controller) {
            $model = Model::factory($controller);
            $dataManager = new DataManager($model);
            $controller = new CRUDController($dataManager);

            $response = $controller->create($request);

            return $response;

        })->assert('controller', '[a-z]+');

        $controllers->get('/{controller}', function ($controller) {
            $model = Model::factory($controller);
            $dataManager = new DataManager($model);
            $controller = new CRUDController($dataManager);

            $response = $controller->read();

            return $response;
        });

        $controllers->get('/{controller}/{id}', function ($controller, $id) {
            $model = Model::factory($controller);
            $dataManager = new DataManager($model);
            $controller = new CRUDController($dataManager);

            $response = $controller->one($id);

            return $response;
        });

        $controllers->put('/{controller}/{id}', function (Request $request, $controller, $id) {
            $model = Model::factory($controller);
            $dataManager = new DataManager($model);
            $controller = new CRUDController($dataManager);

            $response = $controller->update($id, $request);

            return $response;
        });

        $controllers->delete('/{controller}/{id}', function ($controller, $id) {
            $model = Model::factory($controller);
            $dataManager = new DataManager($model);
            $controller = new CRUDController($dataManager);

            $response = $controller->delete($id);

            return $response;
        });

        return $controllers;
    }
}