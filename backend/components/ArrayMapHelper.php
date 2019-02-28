<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 23.10.2015
 * Time: 12:03
 */

namespace backend\components;

use yii\helpers\ArrayHelper;

class ArrayMapHelper
{
    public static function cmap($array, $id, $concattrs=[], $separator=' '){
        $result = [];
        foreach ($array as $element) {
            $key = ArrayHelper::getValue($element, $id);
            $value=[];
            foreach($concattrs as $el){
                $value[] = ArrayHelper::getValue($element, $el);
            }
            $result[$key] = implode($separator, $value);
        }

        return $result;

    }

}