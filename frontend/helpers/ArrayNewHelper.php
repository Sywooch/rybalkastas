<?php

/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 09.03.2017
 * Time: 12:06
 */

namespace frontend\helpers;

class ArrayNewHelper
{
    public static function find_key_value($array, $val)
    {
        foreach ($array as $item)
        {
            if (is_array($item) && self::find_key_value($item, $val)) return true;

            if (isset($item) && $item == $val) return true;
        }

        return false;
    }
}



