<?php

namespace App;

interface DataManagerInterface
{
    /**
     * @param array $data
     *
     * @return array|null
     */
    public function create(array $data);

    /**
     * @return array
     */
    public function read();

    /**
     * @param int   $id
     * @param array $data
     *
     * @return array|null
     */
    public function update($id, array $data);

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function delete($id);

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function one($id);

    /**
     * @param int $id
     *
     * @return bool
     */
    public function exists($id);
}