<?php

namespace App\Provider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

interface ResponseProviderInterface
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request);

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete($id);

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function one($id);

    /**
     * @return JsonResponse
     */
    public function read();

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update($id, Request $request);
}