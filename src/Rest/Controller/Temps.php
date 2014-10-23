<?php

namespace Rest\Controller;

use Silex\Application;
use Rest\Model\Model;
use Rest\Model\Temp;

class Temps extends Controller
{
    protected static $model = 'Rest\Model\Temp';

    protected static $includes = array();
}