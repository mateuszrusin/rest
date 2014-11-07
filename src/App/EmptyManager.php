<?php

namespace App;

use App\Model\Model;
use Silex\Application;

class EmptyManager implements DataManagerInterface
{
    /**
     * @param int $id
     *
     * @return bool
     */
    public function exists($id)
    {
        return true;
    }

    /**
     * @return array
     */
    public function read()
    {
        return array(range(1,5), range(10,20));
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function one($id)
    {
        return range(1,$id);
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return array|null
     */
    public function update($id, array $data)
    {
        return array();
    }

    /**
     * @param array $data
     *
     * @return array|null
     */
    public function create(array $data)
    {
        return array();
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function delete($id)
    {
        return array();
    }
}