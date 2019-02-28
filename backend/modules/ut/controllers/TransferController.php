<?php

namespace backend\modules\ut\controllers;

use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Session;
use common\models\SCCategories;
use common\models\SCProducts;
use common\models\ut\Nomenclature;
use common\models\mongo\ProductAttributes;

/**
 * Default controller for the `ut` module
 */
class TransferController extends Controller
{
    /**
     * Renders the index view for the module
     * @param null $code
     * @param null $categoryID
     * @return string
     */
    public function actionIndex($code = null, $categoryID = null)
    {
        $ars = $this->normalizeJson($code);

        return $this->render('index', [
            'nomenclature' => $ars,
            'parent' => $code
        ]);
    }

    /**
     * @param int $categoryID
     * @return string
     */
    public function actionDestination($categoryID = 1)
    {
        $session = new Session();

        $session->open();

        if (!isset($_POST['categoryID'])) {
            if (isset($_POST['codes'])) {
                $data = $_POST['codes'];
                $session['nomenclatureCodes'] = $data;
            }

            $model = SCCategories::find()
                  ->where(['parent' => $categoryID])
                ->orderBy('sort_order ASC')
                    ->all();

            return $this->render('destination', [
                'model' => $model,
                'categoryID' => $categoryID
            ]);
        } else {
            foreach ($session['nomenclatureCodes'] as $nc) {
                $model = SCProducts::find()
                    ->where(['product_code' => $nc])
                      ->one();

                if (!empty($model)) continue;

                $model = new SCProducts;

                $model->product_code = $nc;
                $model->categoryID = $_POST['categoryID'];
                $model->name_ru = "Временное название";
                $model->brief_description_en = "";
                $model->description_en = "";

                $model->save(false);

                //Create Mongo-attributes
                $mongoAttrs = new ProductAttributes();

                $mongoAttrs->product_id = (int)$model->productID;
                $mongoAttrs->params = [];

                $mongoAttrs->save();
                //end Create Mongo-attributes

                $nomenclature = Nomenclature::findByCode($nc);

                $model->name_ru = $nomenclature->name;
                //$model->maxDiscount =
                $model->save(false);

                $cat = SCCategories::findOne($model->categoryID);

                $path = "";

                if (empty($cat)) \Yii::$app->bot->sendMessage(-14068578, $model->categoryID.' категория не существует');

                foreach ($cat->path as $item) {
                    $path .= '/' . $item['name'];
                }

                //\Yii::$app->bot->sendMessage(-14068578, $model->name_ru.' выгружен в категорию - "'.$path.'"');
            }
        }
    }

    public function actionCreateCategory()
    {
        $parentID = $_POST['parentID'];
        $name = $_POST['name'];

        $model = new SCCategories;

        $model->name_ru = $name;
        $model->parent = $parentID;

        if (!$model->save(false)) {
            print_r($model->getErrors());
        }

        return $this->actionDestination($parentID);
    }

    function normalizeJson($parent)
    {
        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
        //echo file_get_contents($url);

        $client = new \SoapClient($url, [
            'login' => 'siteabserver',
            'password' => 'revresbaetis'
        ]);

        $ar = $client->loadTree(['parent'=>$parent]);
        $ars = json_decode($ar->return);

        $serial = [];

        foreach ($ars as $a){
            $element = new Nomenclature($a);
            $serial[] = $element;
        }

        return $serial;
    }
}
