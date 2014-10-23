<?php

namespace Rest\Controller;

use Rest\Model\Model;
use Rest\Model\Animal;

class Animals extends Controller
{
    protected static $model = 'Rest\Model\Animal';

    protected static $includes = array(
        Model::BREED,
        Model::HOUSE,
        Model::TEMP,
        Model::TYPE
    );

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    protected function getOne($id)
    {
        $result = parent::getOne($id);
        $result['photos'] = $this->getPhotos($id);

        return $result;
    }

    /**
     * @param $id
     *
     * @return array
     */
    private function getPhotos($id)
    {
        $result = array();
        // ...
        return $result;
    }
}