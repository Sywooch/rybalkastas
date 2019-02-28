<?php

namespace console\controllers;

use common\components\ArrayToXmlA;
use common\components\UtUploader;
use common\models\mongo\ProductInfo;
use common\models\SCCategories;
use common\models\SCCategoriesSearch;
use common\models\SCCities;
use common\models\SCCustomers;
use common\models\SCMonufacturers;
use common\models\SCOrderedCarts;
use common\models\SCOrders;
use common\models\SCParentalConnections;
use common\models\SCProductPictures;
use common\models\SCProducts;
use common\models\SCRelatedCategories;
use common\models\SCSecondaryPagesLinks;
use common\models\SCTags;
use common\models\stack\StackTaskPacks;
use common\models\stack\StackTasks;
use common\models\SubscribedMails;
use common\models\User;
use common\models\ut\Nomenclature;
use dektrium\user\helpers\Password;
use Faker\Provider\Base;
use frontend\components\ImageMan;
use frontend\controllers\ShopController;
use frontend\models\OrderingForm;
use yii\console\Controller;
use yii\db\Exception;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseInflector;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\validators\EmailValidator;
use yii\web\Request;
use Yii;
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 10.04.2017
 * Time: 15:08
 */

class SchedulerController extends  Controller
{
    public function actionRun(){
        $this->runNewSqls();
    }

    public function runNewSqls(){
        if(date('i')){
            $folder = Yii::getAlias('@frontend/sql/');
            $files = scandir ($folder);
            if(empty($files[2])) die;
            foreach($files as $k=>$file) {
                if($k < 2) continue;
                $firstFile = $folder . $file;
                $contents = file_get_contents($firstFile);
                unlink($firstFile);
                Yii::$app->db->createCommand($contents)->execute();
            }


        }
    }
}