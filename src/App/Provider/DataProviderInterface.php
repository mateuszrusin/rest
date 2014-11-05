<?php

namespace App\Provider;

interface DataProviderInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function create(array $data);

    /**
     * @param int $id
     *
     * @return array
     */
    public function delete($id);

    /**
     * @param int $id
     *
     * @return bool
     */
    public function exists($id);

    /**
     * @param int $id
     *
     * @return array
     */
    public function one($id);

    /**
     * @return array
     */
    public function read();

    /**
     * @param int   $id
     * @param array $data
     *
     * @return array
     */
    public function update($id, array $data);
}