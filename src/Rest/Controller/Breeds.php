<?php

namespace Rest\Controller;

use Silex\Application;
use Rest\Model\Model;
use Rest\Model\Breed;

class Breeds extends Controller
{
    protected static $model = 'Rest\Model\Breed';

    protected static $includes = array(
        Model::TYPE
    );
}