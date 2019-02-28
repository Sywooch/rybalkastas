<?php
namespace frontend\controllers;

use backend\models\UploadForm;
use common\models\SCAuxPages;
use common\models\SCCategories;
use common\models\SCProductOptionsValues;
use common\models\SCProducts;
use common\models\ut\Nomenclature;
use Yii;
use frontend\models\ContactForm;
use yii\caching\TagDependency;
use yii\db\IntegrityException;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class ShopAdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['contentField'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        echo '';
    }
    
    public function actionClearCacheCategory($id){
        TagDependency::invalidate(Yii::$app->cache, 'category_'.$id);
        $this->redirect(Yii::$app->request->referrer);
        /*Yii::$app->dbCache->flush();
        $this->redirect(Yii::$app->request->referrer);*/
    }

    public function actionRenderEditProduct($id){
        $model = SCProducts::findOne($id);
        return $this->renderAjax('//shop/category/product_views/parts/admin/_product_chunk', ['model'=>$model]);
    }

    public function actionSubmitEditProduct($id){
        $model = SCProducts::findOne($id);
        if(isset($_POST['SCProducts'])){
            $model->attributes = $_POST['SCProducts'];
            $model->save(false);
        }

        if(isset($_POST['SCProductOptionsValues'])){
            foreach ($_POST['SCProductOptionsValues'] as $k=>$pOption){
                if(empty($pOption))continue;
                $optionVal = SCProductOptionsValues::find()->where(['optionID'=>$k])->andWhere(['productID'=>$model->productID])->one();
                if(empty($optionVal)){
                    $optionVal = new SCProductOptionsValues();
                    $optionVal->productID = $model->productID;
                    $optionVal->optionID = $k;
                }
                $optionVal->option_value_ru = $pOption['option_value_ru'];
                $optionVal->save(false);
            }
        }

        TagDependency::invalidate(Yii::$app->cache, ["product_options_values_" . $model->productID]);

        return $this->renderAjax('//shop/category/product_views/parts/_product_chunk', ['model'=>$model]);
    }

    public function actionRenderEditPage($id){
        $model = SCAuxPages::findOne($id);
        return $this->renderAjax('//page/admin/index', ['model'=>$model]);
    }
    public function actionSubmitEditPage($id){
        $model = SCAuxPages::findOne($id);
        if(isset($_POST['SCAuxPages'])){
            $model->attributes = $_POST['SCAuxPages'];
            $model->save(false);
            return $this->renderAjax('//page/index', ['model'=>$model]);

        } else {
            return $this->renderAjax('//page/index', ['model'=>$model]);
        }

    }


    public function actionUpload() {

        $base_path = Yii::getAlias('@frontend');
        $web_path = Yii::getAlias('@web');
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstanceByName('file');

            if ($model->validate()) {
                $model->file->saveAs($base_path . '/web/img/upload/' . $model->file->baseName . '.' . $model->file->extension);
            }
        }

        // Get file link
        $res = array (
            //'link'    => $web_path . '/img/upload/' . $model->file->baseName . '.' . $model->file->extension,
            'link'    =>\Yii::$app->urlManager->createAbsoluteUrl("/img/upload/".$model->file->baseName . '.' . $model->file->extension),
        );

        // Response data
        return json_encode($res);
    }

    public function actionUploadFile() {

        $base_path = Yii::getAlias('@frontend');
        $web_path = Yii::getAlias('@web');
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstanceByName('file');

            if ($model->validate()) {
                $model->file->saveAs($base_path . '/web/public/' . $model->file->baseName . '.' . $model->file->extension);
            }
        }

        // Get file link
        $res = array (
            //'link'    => $web_path . '/img/upload/' . $model->file->baseName . '.' . $model->file->extension,
            'link'    =>\Yii::$app->urlManager->createAbsoluteUrl("/public/".$model->file->baseName . '.' . $model->file->extension),
        );

        // Response data
        return json_encode($res);
    }

    public function actionLoadImages()
    {
        $base_path = Yii::getAlias('@frontend');
        $files = scandir($base_path . '/web/img/upload/');
        $res = [];
        foreach ($files as $f){
            $image = [];
            $image['url'] = \Yii::$app->urlManager->createAbsoluteUrl("/img/upload/".$f);
            $image['thumb'] = \Yii::$app->urlManager->createAbsoluteUrl("/img/upload/".$f);
            $image['tag'] = "";
            $res[] = $image;
        }

        return json_encode($res);
    }


    public function beforeAction($action)
    {
        if ($action->id == 'upload' || $action->id == 'upload-file' )  {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }



    public function actionRagnar()
    {
        $ts = time();

        $folder = Yii::getAlias('@frontend/ragnar');

        $file = $folder."/errors_$ts.html";

        $allCategories = SCCategories::find()->select('categoryID')->asArray()->all();
        foreach ($allCategories as $c){
            try {
                Yii::$app->runAction('shop/category', ['id' => $c['categoryID']]);
            } catch (\Exception $e){
                $error_msg = $e->getTraceAsString();
                $h3 = "categoryID = ".$c['categoryID'];

                $html = <<< HTML
                        <div>
                            <h3>$h3</h3>
                            <div class="errorcode">
                            <code>$error_msg</code>
                            </div>
                        </div>
                        <hr>
                        <hr>
                        <hr>

HTML;
                file_put_contents($file, $html);
            }
        }
    }


    public function actionSyncUt($id){
        $model = SCProducts::findOne($id);
        Nomenclature::findByCode($model->product_code);
        $this->redirect(['shop/category', 'id'=>$model->categoryID, 'product'=>$model->productID]);
    }

    public function actionCheckts($id){
        $model = SCProducts::findOne($id);
        $stock = 1;
        $provider = 1;
        $reserved = 1;

        $fullStock = $stock + $provider;
        $actualStock = $fullStock - $reserved;

        if($actualStock < 0)$actualStock = 0;
        if($fullStock == 0)$provider = 0;

        $model->in_stock = $actualStock;
        $model->in_stock_provider = $provider;
        if(!$model->save()){
            print_r( $model->getErrors());
        }
    }

    public function actionToggleInfo($id)
    {
        $session = Yii::$app->session;
        if(empty($session['showInfo'])){
            $session->set('showInfo', 1);
        } else {
            $session->remove('showInfo');
        }

        $this->redirect(['shop/category', 'id'=>$id]);
    }
}