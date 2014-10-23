<?php

namespace Rest\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class Controller
{
    /**
     * @param string $controller
     *
     * @return Controller
     */
    public static function factory($controller)
    {
        $class = __NAMESPACE__.NS.ucfirst($controller);

        return new $class;
    }
    /**
     * @return Response
     */
    public static function run()
    {
        return new Response('OK');
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function one($id)
    {
        if ($id) {
            $result = $this->getOne($id);

            return new JsonResponse($result, JsonResponse::HTTP_OK);
        }

        return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
    }

    /**
     * @return JsonResponse
     */
    public function read()
    {
        $result = $this->getAll();

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }

    /**
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }

        $class = static::$model;
        $model = $class::find($id);

        if (!$model) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        $data = array_intersect_key($data, $model->attributes());

        if (!$data) {
            return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }

        $model->update_attributes($data);
        $result = $model->to_array($this->getSerializationParams());

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->request->all();

        if (!$data) {
            return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }

        $class = static::$model;
        $model = $class::create($data);

        if (!$model) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        $result = $model->to_array();

        $response = new JsonResponse;
        $response->setStatusCode(JsonResponse::HTTP_CREATED);
        $response->setData($result);
        $response->headers->set('location', $request->getUri().$model->id);

        return $response;
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete($id)
    {
        $class = static::$model;
        $model = $class::find($id);

        if (!$model) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        $model->delete();

        return new JsonResponse(array(), JsonResponse::HTTP_OK);

    }

    /**
     * @param $id
     *
     * @return array
     */
    protected function getOne($id)
    {
        $class = static::$model;
        $model = $class::find($id);

        if (!$model) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        $result = $model->to_array($this->getSerializationParams());

        return $result;
    }

    /**
     * @return array
     */
    protected function getAll()
    {
        $class = static::$model;
        $serializationParams = $this->getSerializationParams();
        $result = $class::all($serializationParams);

        if (!is_array($result)) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        foreach ($result as &$model) {
            $model = $model->to_array($serializationParams);
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getSerializationParams()
    {
        return array('include' => static::$includes);
    }
}