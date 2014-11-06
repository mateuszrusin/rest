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

        $controllers->post('/{resource}', function (Request $request, $resource) {
            $model = Model::factory($resource);
            $dataManager = new DataManager($model);
            $crudController = new CRUDController($dataManager);

            $response = $crudController->create($request);

            return $response;

        })->assert('controller', '[a-z]+');

        $controllers->get('/{resource}', function ($resource) {
            $model = Model::factory($resource);
            $dataManager = new DataManager($model);
            $crudController = new CRUDController($dataManager);

            $response = $crudController->read();

            return $response;
        });

        $controllers->get('/{resource}/{id}', function ($resource, $id) {
            $model = Model::factory($resource);
            $dataManager = new DataManager($model);
            $crudController = new CRUDController($dataManager);

            $response = $crudController->one($id);

            return $response;
        });

        $controllers->put('/{resource}/{id}', function (Request $request, $resource, $id) {
            $model = Model::factory($resource);
            $dataManager = new DataManager($model);
            $crudController = new CRUDController($dataManager);

            $response = $crudController->update($id, $request);

            return $response;
        });

        $controllers->delete('/{resource}/{id}', function ($resource, $id) {
            $model = Model::factory($resource);
            $dataManager = new DataManager($model);
            $crudController = new CRUDController($dataManager);

            $response = $crudController->delete($id);

            return $response;
        });

        return $controllers;
    }
}