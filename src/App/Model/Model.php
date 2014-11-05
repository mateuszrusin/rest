<?php

namespace App\Model;

class Model extends \ActiveRecord\Model
{
    const ANIMAL = 'animal';
    const BREED = 'breed';
    const HOUSE = 'house';
    const TEMP = 'temp';
    const TYPE = 'type';

    public static function factory($model)
    {
        $class = __NAMESPACE__.NS.ucfirst($model);

        return new $class;
    }

    public function getSerializationParams()
    {
        $includes = array();

        foreach (static::$belongs_to as $table) {
            $includes[] = reset($table);
        }

        return array('include' => $includes);
    }
};
?>
