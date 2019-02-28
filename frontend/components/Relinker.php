<?php
namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\base\BootstrapInterface;
use yii\helpers\Url;

/**
 * Class Maintenance
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Relinker extends Component implements BootstrapInterface
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
        $beginUrl = $_SERVER['REQUEST_URI'];


        $array = ['/Base/', '/Bottoms/', '/Face/', '/features/', '/flv/', '/folder_for_images/'];
        foreach ($array as $ar){
            if (strpos($ar, $_SERVER['REQUEST_URI']) !== FALSE) { // Yoshi version
                $beginUrl = str_replace($ar, '', $beginUrl);
            }
        }

        $url = explode('?',$beginUrl);


        if(isset($url[1])){
            $url = $url[1];
            parse_str($url, $output);
            if (isset($output['categoryID']) && isset($output['product'])){
                Yii::$app->response->redirect(['shop/category', 'id'=>$output['categoryID'], 'product'=>$output['product']]);
                return;
            }

            if (isset($output['categoryID']) && !isset($output['product'])){
                Yii::$app->response->redirect(['shop/category', 'id'=>$output['categoryID']]);
                return;
            }

            if (isset($output['ukey']) && strpos($output['ukey'], "auxpage") !== false){
                $split = explode('_', $output['ukey']);
                Yii::$app->response->redirect(['page/index', 'slug'=>$split[1]]);
                return;
            }

            /*if(isset($output['tag']) && !Yii::$app->request->isAjax && !Yii::$app->request->isPjax){
                Yii::$app->response->redirect(['shop/category', 'id'=>$output['tag'], 'SCCategoriesSearch[monufacturer][]'=>$output['mon']]);
            }*/
        }
    }
}
