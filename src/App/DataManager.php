<?php

namespace App;

use App\Model\Model;
use Silex\Application;

class DataManager implements DataManagerInterface
{
    /**
     * @var Model
     */
    private $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function exists($id)
    {
        $modelClass = $this->getModelClass();

        return $modelClass::exists($id);
    }

    /**
     * @return array
     */
    public function read()
    {
        $modelClass = $this->getModelClass();
        $serializationParams = $this->model->getSerializationParams();

        $result = $modelClass::all($serializationParams);

        foreach ($result as &$model) {
            $model = $model->to_array($serializationParams);
        }

        return $result;
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function one($id)
    {
        $modelClass = $this->getModelClass();
        $result = $modelClass::find($id);

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
     * @return array|null
     */
    public function update($id, array $data)
    {
        $modelClass = $this->getModelClass();
        $model = $modelClass::find($id);

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
     * @return array|null
     */
    public function create(array $data)
    {
        $modelClass = $this->getModelClass();
        $model = $modelClass::create($data);

        if (!$model) {
            return null;
        }

        $result = $model->to_array();

        return $result;
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function delete($id)
    {
        $modelClass = $this->getModelClass();
        $model = $modelClass::find($id);

        if (!$model) {
            return null;
        }

        $model->delete();

        return array();
    }

    /**
     * @return string
     */
    private function getModelClass()
    {
        return get_class($this->model);
    }
}