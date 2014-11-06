<?php

namespace App\Provider;

use App\Model\Model;
use App\Provider\ResponseProvider;
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
            $dataProvider = new ResponseProvider($controller);
            $response = $dataProvider->create($request);

            return $response;
        })->assert('controller', '[a-z]+');

        $controllers->get('/{controller}', function ($controller) {
            //entity?
            $model = Model::factory($controller);
            //then Model?
            $dataManager = new DataManager($model);
            $controller = new Controller($dataManager);
            $response = $controller->read();

            return $response;
        });

        $controllers->get('/{controller}/{id}', function ($controller, $id) {
            $dataProvider = new ResponseProvider($controller);
            $response = $dataProvider->one($id);

            return $response;
        });

        $controllers->put('/{controller}/{id}', function (Request $request, $controller, $id) {
            $dataProvider = new ResponseProvider($controller);
            $response = $dataProvider->update($id, $request);

            return $response;
        });

        $controllers->delete('/{controller}/{id}', function ($controller, $id) {
            $dataProvider = new ResponseProvider($controller);
            $response = $dataProvider->delete($id);

            return $response;
        });

        return $controllers;
    }
}