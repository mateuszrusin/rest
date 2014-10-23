<?php

namespace Rest\Controller;

use Rest\Model\Model;
use Rest\Model\Animal;
use Rest\Tool\SimpleImage;

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
        $dir  = ROOT_PATH.DS.'html'.DS.'files'.DS.'animals'.DS.$id;
        $dir_mini = $dir.DS.'mini';
        $path = PS.'html'.PS.'files'.PS.'animals'.PS.$id.PS;
        $path_mini = $path.'mini'.PS;
        if ($arr = glob($dir.DS.'*.jpg'))
        {
            foreach ($arr as $item)
            {
                list($width, $height) = getimagesize($item);
                $parts = explode(DS,$item);
                $file = end($parts);
                if (!is_file($dir_mini.DS.$file)) {
                    $img = new SimpleImage($item);
                    $img->adaptive_resize(80, 80);
                    $img->save($dir_mini.DS.$file);
                }
                $result[] = array(
                    'path'   => $path.$file,
                    'mini'   => $path_mini.$file,
                    'width'	 => $width,
                    'height' => $height
                );
            }
        }

        return $result;
    }
}