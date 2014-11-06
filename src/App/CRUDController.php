<?php

namespace App;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CRUDController implements ControllerInterface
{
    /**
     * @var DataManager
     */
    private $dataManager;

    /**
     * @param DataManager $dataManager
     */
    public function __construct(DataManager $dataManager) {
        $this->dataManager = $dataManager;
    }

    /**
     * @return JsonResponse
     */
    public function read()
    {
        $result = $this->dataManager->read();

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
        $result = $this->dataManager->one($id);

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

        if (!$this->dataManager->exists($id)) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        $result = $this->dataManager->update($id, $data);

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

        $result = $this->dataManager->create($data);

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
        if (!$this->dataManager->exists($id)) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        $result = $this->dataManager->delete($id);

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }
}