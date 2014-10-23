<?php

namespace Rest\Model;

use Rest\Model\Model;

class Breed extends Model {
    protected static $belongs_to = array (
        array(self::TYPE, 'foreign_key' => 'id_type')
    );
}