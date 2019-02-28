<?php
namespace frontend\components;

use common\components\UtUploader;
use common\models\SCCustomers;
use Yii;
use yii\base\Component;
use yii\base\BootstrapInterface;

/**
 * Class Maintenance
 * @author Eugene Terentev <eugene@terentev.net>
 */
class AutoLink extends Component implements BootstrapInterface
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
        if(!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity;
            if(empty($user->customer)){
                if(!$user->linkOnAir()){
                    $user->linkNew();
                }
            }

            if(empty($user->customer->{'1c_id'})){
                if(empty($user->customer)){
                    $newCustomer = new SCCustomers;
                    $newCustomer->user_id = $user->getId();
                    $newCustomer->save();
                    $user = Yii::$app->user->identity;
                }

                $uploader = new UtUploader;

                @$uploader->UploadCustomer($user->customer);
            }



            if(empty($user->customer->card)){
                $key = "check_card_autolink_ut_".$user->id;

                $data = \Yii::$app->cache->get($key);
                if(empty($data)){
                    $uploader = new \common\components\UtUploader();
                    if($uploader->client && $uploader->CheckCard($user->email)){
                        $data = 'yes';
                    } else {
                        $data = 'no';
                    }
                    \Yii::$app->cache->set($key, $data, 7200);
                }

                /*$data = \Yii::$app->cacheRedis->getOrSet($key, function () use ($user) {
                    $uploader = new \common\components\UtUploader();
                    echo 12312312;
                    if($uploader->client && $uploader->CheckCard($user->email)){
                        return true;
                    } else {
                        return false;
                    }
                }, 7200);*/

                if($data == 'yes'){
                    $uploader = new \common\components\UtUploader();
                    $uploader->MoveCard($user);
                }
            }

        }


    }
}
