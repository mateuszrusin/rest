<?php

namespace App\Provider;

use App\Model\Model;
use Silex\Application;

class DataProvider implements DataProviderInterface
{
    private $model;

    public function __construct($controller) {
        $this->model = Model::factory($controller);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function exists($id)
    {
        $model = get_class($this->model);
        return $model::exists($id);
    }

    /**
     * @return array
     */
    public function read()
    {
        $model = get_class($this->model);
        $serializationParams = $this->model->getSerializationParams();

        $result = $model::all($serializationParams);

        foreach ($result as &$model) {
            $model = $model->to_array($serializationParams);
        }

        return $result;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function one($id)
    {
        $model = get_class($this->model);
        $result = $model::find($id);

        if (!$result) {
            return null;
        }

        $result = $result->to_array($this->model->getSerializationParams());

        return $result;
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return array
     */
    public function update($id, array $data)
    {
        $class = get_class($this->model);
        $model = $class::find($id);

        $data = array_intersect_key($data, $model->attributes());

        if (!$data) {
            return null;
        }

        $model->update_attributes($data);
        $result = $model->to_array($this->model->getSerializationParams());

        return $result;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function create(array $data)
    {
        $class = get_class($this->model);
        $model = $class::create($data);

        if (!$model) {
            return null;
        }

        $result = $model->to_array();

        return $result;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function delete($id)
    {
        $class = get_class($this->model);
        $model = $class::find($id);

        if (!$model) {
            return null;
        }

        $model->delete();

        return array();
    }
}