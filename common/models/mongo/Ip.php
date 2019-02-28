<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 21.04.2017
 * Time: 10:01
 */

namespace common\models\mongo;

use yii\base\Model;
use yii2tech\embedded\ContainerInterface;
use yii2tech\embedded\ContainerTrait;

class Ip extends Model implements ContainerInterface
{
    use ContainerTrait;

    public $ip;

}
