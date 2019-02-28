<?php

namespace frontend\components\absence;

use Yii;
use common\models\mongo\Ip;
use common\models\mongo\Ips;
use common\models\mongo\IpsByDate;
use yii\base\Component;
use yii\base\BootstrapInterface;
use yii\web\Cookie;

/**
 * Class Maintenance
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Absence extends Component implements BootstrapInterface
{
    /**
     * @var boolean|\Closure boolean value or Closure that return
     * boolean indicating if app in maintenance mode or not
     */

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param \yii\web\Application $app the application currently running
     */
    public function bootstrap($app)
    {

        if (!empty($_SERVER['REMOTE_ADDR'])) {
            $key = "ipsByDateCache_".$_SERVER['REMOTE_ADDR'];
            $wasToday = Yii::$app->cache->get($key);

            if ($wasToday === false) {
                $now = time();
                $next = strtotime('tomorrow');
                $duration = $next-$now;

                IpsByDate::updateAll(
                    ['$addToSet' => ['ips' => $_SERVER['REMOTE_ADDR']]],
                    ['date' => date('d-m-Y')],
                    ['upsert' => true]
                );

                Yii::$app->cache->set($key, 1, $duration);
            }

            $session = Yii::$app->session;

            $cookies = Yii::$app->response->cookies;

            if (!empty($_GET['srcref']) || !empty($cookies->getValue('srcref'))) {
                if($_SERVER['REMOTE_ADDR'] == "176.107.242.44"){
                    echo $cookies->getValue('srcref');
                }

                $val = !empty($_GET['srcref'])?$_GET['srcref']:$cookies->getValue('srcref');
                $val = \yii\helpers\HtmlPurifier::process($val);

                if (empty($cookies->getValue('srcref'))) {
                    $cookie = new Cookie([
                        'name'=>'srcref',
                        'value'=>$val,
                        'expire'=>time()+86400*365
                    ]);
                }

                $cookies->add($cookie);

                if (!isset($session['srcref'])) {
                    $session->set('srcref', $val);
                }
            }

            if ((isset($_GET['srcref']) && !isset($session['srcref'])) || (isset($_GET['srcref']) && !isset($session['srcref']))) {
                $val = \yii\helpers\HtmlPurifier::process($_GET['srcref']);
                $session->set('srcref', $val);
            }

            $r = boolval(Yii::$app->settings->get('main', 'absence'));

            Yii::$app->settings->invalidateCache();

            if ($r == 1) {
                if (!Yii::$app->user->can('Employee')) {
                    //if ($_SERVER['REMOTE_ADDR'] != "176.107.242.44") {
                        $app->catchAll = ['absence/index'];
                    //}
                }
            }
        }

        //if (Yii::$app->user->can('superField')) {
            Yii::$app->view->theme = new \yii\base\Theme([
                'basePath' => '@app/themes/christmas',
                'baseUrl' => '@web/themes/christmas',
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user',
                    '@app/views' => '@app/themes/christmas',
                ],
            ]);
        //}
    }
}
