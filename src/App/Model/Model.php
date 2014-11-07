<?php

namespace App\Model;

class Model extends \ActiveRecord\Model
{
    const ANIMAL = 'animal';
    const BREED = 'breed';
    const HOUSE = 'house';
    const VET = 'vet';
    const TYPE = 'type';

    /**
     * @var array
     */
    protected static $belongs_to = array();

    /**
     * @param string $modelName
     *
     * @return Model
     */
    public static function factory($modelName)
    {
        $class = __NAMESPACE__.NS.ucfirst($modelName);

        return new $class;
    }

    /**
     * @return array
     */
    public function getSerializationParams()
    {
        $includes = array();

        foreach (static::$belongs_to as $table) {
            $includes[] = reset($table);
        }

        return array('include' => $includes);
    }
};
