<?php

namespace Rest\Model;

use Rest\Model\Model;

class Animal extends Model {
    protected static $belongs_to = array (
        array(self::TYPE, 'foreign_key' => 'id_type'),
        array(self::BREED, 'foreign_key' => 'id_breed'),
        array(self::HOUSE, 'foreign_key' => 'id_house'),
        array(self::TEMP, 'foreign_key' => 'id_temp')
    );
}