<?php
namespace frontend\components\absence;

use common\models\mongo\Ip;
use common\models\mongo\Ips;
use common\models\mongo\IpsByDate;
use Yii;
use yii\base\Component;
use yii\base\BootstrapInterface;
use yii\web\Cookie;

/**
 * Class Maintenance
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Reminder extends Component implements BootstrapInterface
{
    public function bootstrap($app)
    {

    }
}