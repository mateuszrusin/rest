<?php

namespace App\Provider;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseProvider implements ResponseProviderInterface
{
    private $dataProvider;

    public function __construct($controller) {
        $this->dataProvider = new DataProvider($controller);
    }

    /**
     * @return JsonResponse
     */
    public function read()
    {
        $result = $this->dataProvider->read();

        if (!is_array($result)) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function one($id)
    {
        $result = $this->dataProvider->one($id);

        if (!is_array($result)) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

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

        if (!$this->dataProvider->exists($id)) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        $result = $this->dataProvider->update($id, $data);

        if (!$result) {
            return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }

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
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }

        $result = $this->dataProvider->create($data);

        if (!$result) {
            return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete($id)
    {
        if (!$this->dataProvider->exists($id)) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        $result = $this->dataProvider->delete($id);

        return new JsonResponse($result, JsonResponse::HTTP_OK);

    }
}