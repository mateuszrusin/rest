<?php

namespace Rest\Controller;

use Silex\Application;
use Rest\Model\Model;
use Rest\Model\House;

class Houses extends Controller
{
    protected static $model = 'Rest\Model\House';

    protected static $includes = array();
}