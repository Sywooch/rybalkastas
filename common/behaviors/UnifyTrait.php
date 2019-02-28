<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 26.07.2017
 * Time: 11:36
 */

namespace common\behaviors;

trait UnifyTrait
{
    public $name;
    public $type;
    public $fieldTypes = [];


    public function fields()
    {
        $fields = parent::fields();
        return 'asd';
    }

}