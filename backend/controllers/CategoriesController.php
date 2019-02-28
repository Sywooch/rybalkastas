<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\Session;
use yii\web\View;
use yii\filters\VerbFilter;
use yii\imagine\Image;
use zxbodya\yii2\elfinder\ConnectorAction;
use common\models\SCParentalConnections;
use common\models\SCProductOptions;
use common\models\SCProductOptionsValues;
use common\models\SCProductPictures;
use common\models\SCProducts;
use common\models\SCRelatedCategories;
use common\models\SCSameCategories;
use common\models\Trash;
use common\models\UserActivity;
use common\models\UserNotifications;
use common\models\SCCategories;
use common\models\SCCategoriesSearch;
use common\models\mongo\ProductAttributes;


/**
 * CategoriesController implements the CRUD actions for SCCategories model.
 */
class CategoriesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-type' => ['POST']
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'minipicconnector' => array(
                'class' => ConnectorAction::className(),
                'settings' => array(
                    'root' => '/var/www/published/publicdata/TESTRYBA/attachments/SC/products_colors/',
                    'URL' => '/published/publicdata/TESTRYBA/attachments/SC/products_colors/',
                    'rootAlias' => 'Home',
                    'mimeDetect' => 'none'
                )
            ),
        ];
    }

    /**
     * Lists all SCCategories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $cat = 1;
        $cookie = Yii::$app->request->cookies['catalogAdminPosition'];
        $cookieVal = Yii::$app->request->cookies->getValue('catalogAdminPosition');
        if(!empty($cookie)){
            $cat = $cookie;
        }

        if(!empty($cookieVal) || $cookieVal != ''){
            $c = SCCategories::find()->where("categoryID = $cookieVal")->one();
            if(empty($c)){
                $cat = 1;
            }
        } else {
            $cat = 1;
        }

        $model = SCCategories::find()->where("parent = 1")->orderBy('main_sort')->all();
        $products = SCProducts::find()->where('categoryID = '.$cat)->orderBy('sort_order')->all();
        $categoryID = 1;
        return $this->render('index', [
            'model'=>$model,
            'products'=>$products,
            'categoryID' => $cat
        ]);
    }

    public function actionLoadcats(){
        $root = $_REQUEST['root'];


        $sub = SCParentalConnections::find()->where("parent = ".$root)->all();
        $ar = array();
        foreach($sub as $s){
            $ar[] = $s->categoryID;
        }

        if(isset($_COOKIE['openedCats'])){
            $cookie = unserialize($_COOKIE['openedCats']);
        } else {
            $cookie = array();
        }

        $cookie[] = $root;

        setcookie('openedCats', serialize($cookie), time()+13600);

        $model = SCCategories::find()->where("parent = ".$root)->orderBy('sort_order ASC ')->all();
        /*->orWhere(['in', 'categoryID', $ar])->*/
        $children = SCCategories::find()->where(['in', 'categoryID', $ar])->orderBy("sort_order ASC")->all();

        return $this->renderAjax('subtree', [
            'model'=>$model,
            //'child'=>$children,
        ]);
    }

    public function actionLoadprds(){
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'catalogAdminPosition',
            'value' => $_POST['cat']
        ]));
        $root = $_POST['cat'];
        $model = SCProducts::find()->where("categoryID = ".$root)->orderBy('sort_order')->all();

        return $this->renderAjax('products', [
            'products'=>$model,
            'categoryID'=>$root,
        ]);
    }

    public function actionUnloadcookie(){
        $c = $_POST['closed'];
        $cookie = unserialize($_COOKIE['openedCats']);
        if(($key = array_search($c, $cookie)) !== false) {
            unset($cookie[$key]);
        }
        setcookie('openedCats', serialize($cookie), time()+13600);
    }

    /**
     * Displays a single SCCategories model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SCCategories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SCCategories();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->categoryID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SCCategories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $rootCats = SCCategories::find()
              ->where(['parent' => 1])
            ->orderBy('main_sort')
                ->all();

        $nearCats = SCCategories::find()
               ->where(['parent' => $model->parent])
            ->andWhere(['!=', 'categoryID', $id])
             ->orderBy('main_sort')
                 ->all();

        $beforeImage = $model->picture;

        $beforeHeadpirture = $model->head_picture;
        $beforeMenupicture = $model->menupicture;

        $base_path = Yii::getAlias('@frontend');

        //$_POST['SCCategories']['tags'] = implode(',', $_POST['SCCategories']['tags']);

        if ($model->load(Yii::$app->request->post())) {
            $image = UploadedFile::getInstance($model, 'picture');

            if (!empty($image)) {
                $filename = explode(".", $image->name);

                $ext = $filename[1];

                $model->picture = Yii::$app->security->generateRandomString(26).".{$ext}";

                $path = $base_path . '/web/img/products_pictures/' . $model->picture;

                $image->saveAs($path);
            } else {
                $model->picture = $beforeImage;
            }

            $hp_image = UploadedFile::getInstance($model, 'head_picture');

            if (!empty($hp_image)) {
                $filename = explode(".", $hp_image->name);

                $ext = $filename[1];

                $model->head_picture = Yii::$app->security->generateRandomString(26).".{$ext}";

                $path = $base_path . '/web/img/products_pictures/' . $model->head_picture;

                $hp_image->saveAs($path);
            } else {
                $model->head_picture = $beforeHeadpirture;
            }

            $mp_image = UploadedFile::getInstance($model, 'menupicture');

            if (!empty($mp_image)) {
                $filename = explode(".", $mp_image->name);

                $ext = $filename[1];

                $model->menupicture = Yii::$app->security->generateRandomString(26).".{$ext}";

                $path = $base_path . '/web/img/products_pictures/' . $model->menupicture;

                $mp_image->saveAs($path);
            } else {
                $model->menupicture = $beforeMenupicture;
            }

            if (isset($_POST['parents'])) {
                foreach ($_POST['parents'] as $k => $v) {
                    if ($v == 1) {
                        $c = SCParentalConnections::find()
                               ->where(['parent' => $k])
                            ->andWhere(['categoryID' => $id])
                                 ->one();

                        if (!empty($c)) continue;

                        $con = new SCParentalConnections;

                        $con->parent = $k;

                        $con->categoryID = $id;

                        $con->save();
                    } elseif ($v == 0) {
                        $con = SCParentalConnections::find()
                               ->where(['parent' => $k])
                            ->andWhere(['categoryID' => $id])
                                 ->one();

                        if (!empty($con)) {
                            $con->delete();
                        }
                    }
                }
            }

            if (isset($_POST['parentset'])) {
                foreach ($_POST['parentset'] as $k => $v) {
                    if ($v != 1) {
                        $con = SCParentalConnections::find()
                               ->where(['parent' => $k])
                            ->andWhere(['categoryID' => $id])
                                 ->one();

                        if (!empty($con)) {
                            $con->delete();
                        }
                    }
                }
            }

            if (isset($_POST['related'])) {
                foreach ($_POST['related'] as $k => $v) {
                    if ($v == 1) {
                        $c = SCRelatedCategories::find()
                               ->where(['relatedCategoryID' => $k])
                            ->andWhere(['categoryID' => $id])
                                 ->one();

                        if (!empty($c)) continue;

                        $con = new SCRelatedCategories();

                        $con->relatedCategoryID = $k;

                        $con->categoryID = $id;

                        $con->save();
                    } elseif ($v == 0) {
                        $con = SCRelatedCategories::find()
                               ->where(['relatedCategoryID' => $k])
                            ->andWhere(['categoryID' => $id])
                                 ->one();

                        if(!empty($con)){
                            $con->delete();
                        }
                    }
                }
            }

            if (isset($_POST['relatedset'])) {
                foreach ($_POST['relatedset'] as $k => $v) {
                    if ($v != 1) {
                        $con = SCRelatedCategories::find()
                               ->where(['relatedCategoryID' => $k])
                            ->andWhere(['categoryID' => $id])
                                 ->one();

                        if(!empty($con)){
                            $con->delete();
                        }
                    }
                }
            }

            if (isset($_POST['selfrelated'])) {
                foreach ($_POST['selfrelated'] as $k => $v) {
                    if ($v == 1) {
                        $c = SCRelatedCategories::find()
                               ->where(['relatedCategoryID' => $id])
                            ->andWhere(['categoryID' => $k])
                                 ->one();

                        if (!empty($c)) continue;

                        $con = new SCRelatedCategories();

                        $con->relatedCategoryID = $id;
                        $con->categoryID = $k;

                        $con->save();
                    } elseif ($v == 0) {
                        $con = SCRelatedCategories::find()
                               ->where(['relatedCategoryID' => $id])
                            ->andWhere(['categoryID' => $k])
                                 ->one();

                        if (!empty($con)) $con->delete();
                    }
                }
            }

            if (isset($_POST['selfrelatedset'])) {
                foreach ($_POST['selfrelatedset'] as $k => $v) {
                    if ($v != 1) {
                        $con = SCRelatedCategories::find()
                               ->where(['relatedCategoryID' => $id])
                            ->andWhere(['categoryID' => $k])
                                 ->one();

                        if (!empty($con)) $con->delete();
                    }
                }
            }

            if (isset($_POST['childs'])) {
                foreach ($_POST['childs'] as $k=>$v) {
                    if($v == 1){
                        $c = SCParentalConnections::find()
                            ->where("categoryID = $k AND parent = $id")
                              ->one();

                        if (!empty($c)) continue;

                        $con = new SCParentalConnections;

                        $con->categoryID = $k;
                        $con->parent = $id;

                        $con->save();
                    } elseif($v == 0){
                        $con = SCParentalConnections::find()
                            ->where("categoryID = $k AND parent = $id")
                              ->one();

                        if (!empty($con)) {
                            $con->delete();
                        }
                    }
                }
            }

            if (isset($_POST['childset'])) {
                foreach ($_POST['childset'] as $k=>$v) {
                    if ($v != 1) {
                        $con = SCParentalConnections::find()
                            ->where("categoryID = $k AND parent = $id")
                              ->one();

                        if (!empty($con)) {
                            $con->delete();
                        }
                    }
                }
            }

            if (isset($_POST['same'])) {
                foreach ($_POST['same'] as $k=>$v) {
                    if ($v == 1) {
                        $c = SCSameCategories::find()
                            ->where("subcategoryID = $k AND categoryID = $id")
                              ->one();

                        if (!empty($c)) continue;

                        $con = new SCSameCategories();

                        $con->subcategoryID = $k;
                        $con->categoryID = $id;

                        $con->save();

                        $con = new SCSameCategories();

                        $con->subcategoryID = $id;
                        $con->categoryID = $k;

                        $con->save();
                    } elseif($v == 0){
                        $con = SCSameCategories::find()
                            ->where("subcategoryID = $k AND categoryID= $id")
                              ->one();

                        if (!empty($con)) {
                            $con->delete();
                        }

                        $con = SCSameCategories::find()
                            ->where("subcategoryID = $id AND categoryID= $k")
                              ->one();

                        if (!empty($con)) {
                            $con->delete();
                        }
                    }
                }
            }

            if (isset($_POST['sameset'])) {
                foreach ($_POST['sameset'] as $k=>$v) {
                    if ($v != 1) {
                        $con = SCSameCategories::find()
                            ->where("subcategoryID = $k AND categoryID= $id")
                              ->one();

                        if (!empty($con)) {
                            $con->delete();
                        }

                        $con = SCSameCategories::find()
                            ->where("subcategoryID = $id AND categoryID= $k")
                              ->one();

                        if (!empty($con)) {
                            $con->delete();
                        }
                    }
                }
            }

            if($_POST['SCCategories']['picture'] == 'TODELETE')$model->picture = '';
            if($_POST['SCCategories']['head_picture'] == 'TODELETE')$model->head_picture = '';

            if ($model->save(false)) {
                $act = new UserActivity;
                $act->putActivity("Category", $model->categoryID, 'update');

                $notify = new UserNotifications;
                $notify->putMassNotify(\Yii::$app->user->id, "Обновил категорию $model->name_ru");

                Yii::$app->session->setFlash('success', 'Категория сохранена');

            }
        }

        return $this->render('update', [
            'model' => $model,
            'rootCats' => $rootCats,
            'main' => $id,
            'nearCats' => $nearCats,
        ]);
    }

    public function actionLoadsubcatsajax(){
        $root = $_POST['root'];
        $type = $_POST['type'];
        $main = $_POST['main'];

        if(!empty($_POST['template'])){
            $template = $_POST['template'];
        } else {
            $template = '//categories/modaltree';
        }


        $model = SCCategories::find()
              ->where("parent = " . $root)
            ->orderBy('sort_order')
                ->all();

        return $this->renderAjax($template, [
            'rootCats' => $model,
            'type' => $type,
            'main' => $main,
        ]);
    }

    /**
     * Deletes an existing SCCategories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SCCategories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SCCategories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SCCategories::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * =======================
     * ТУТ НАЧИНАЮТСЯ ПРОДУКТЫ
     * =======================
     */

    public function actionEditproduct($id)
    {
        $model = SCProducts::findOne($id);
        $cat_id = $model->categoryID;

        $cookie = SCCategories::catGetParentPath($model->categoryID);
        setcookie('openedCats', serialize($cookie), time()+13600);

        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name'  => 'catalogAdminPosition',
            'value' => $cat_id
        ]));

        $nearProducts = SCProducts::find()
            ->where("categoryID = $cat_id")
              ->all();

        if (isset($_POST['setAttr'])) {
            foreach ($_POST['setAttr'] as $k => $v) {
                $attr = SCProductOptionsValues::find()
                    ->where("productID = $id AND optionID = $k")
                      ->one();

                if (empty($attr)) {
                    $attr = new SCProductOptionsValues;

                    $attr->productID = $id;
                    $attr->optionID = $k;
                    //$attr->save();
                }

                $attr->option_value_ru = $v;
                $attr->save();
            }
        }

        if (isset($_POST['newAttr']) && !empty($_POST['newAttr'])) {
            $oldAttrs = SCProductOptionsValues::find()
                ->where("productID = $id")
                  ->all();

            foreach ($oldAttrs as $atd) {
                $atd->delete();
            }

            foreach ($_POST['newAttr'] as $k => $v) {
                $attr = new SCProductOptionsValues;

                $attr->optionID = $k;
                $attr->productID = $id;
                $attr->option_value_ru = $v;

                $attr->save();
            }
        }

        //Set Mongo-attributes
        if (isset($_POST['setAttr'])) {
            $postAttrs = $_POST['setAttr'];
        } elseif (isset($_POST['newAttr'])) {
            $postAttrs = $_POST['newAttr'];
        } else {
            $postAttrs = [];
        }
        
        $mongoAttrs = ProductAttributes::find()
            ->where(['product_id' => (int)$id])
              ->one();

        if (!$mongoAttrs) {
            //Create Mongo-attributes
            $mongoAttrs = new ProductAttributes();

            $mongoAttrs->product_id = (int)$model->productID;
            $mongoAttrs->params = [];

            $mongoAttrs->save();
            //end Create Mongo-attributes
        }

        $setAttrs = [];

        foreach ($postAttrs as $optionID => $optionValue) {
            $productOption = SCProductOptions::find()
                ->where(['optionID' => $optionID])
                  ->one();

            $setAttrs[] = [
                'name'  => $productOption ? htmlspecialchars($productOption->name_ru) : null,
                'value' => $optionValue,
                'id'    => $optionID,
            ];
        }

        $mongoAttrs->params = $setAttrs;

        $mongoAttrs->save();
        //end Set Mongo-attributes

        if (isset($_POST['attrCat'])) {
            $model->attr_cat = $_POST['attrCat'];
        }

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            $act = new UserActivity;
            $act->putActivity("Product", $model->productID, 'update');

            $notify = new UserNotifications;
            $notify->putMassNotify(\Yii::$app->user->id, "Обновил продукт $model->name_ru");

            yii\caching\TagDependency::invalidate(Yii::$app->cache, "product_options_values_" . $model->productID);
        }

        return $this->render('editproduct', [
            'model'        => $model,
            'nearProducts' => $nearProducts,
        ]);
    }

    public function actionDeletecategory($id)
    {
        $model = SCCategories::find()->where("categoryID = $id")->one();
        if(empty($model))return false;

        $products = SCProducts::find()->where("categoryID = $id")->all();
        foreach ($products as $p) {
            Trash::add($p);
        }
        Trash::add($model);

        $this->redirect(['/categories/']);
    }



    public function actionDeleteproduct($id){
        $model = SCProducts::findOne($id);
        /*if(Yii::$app->user->can('headField')){
            if($model->delete()){
                $act = new UserActivity;
                $act->putActivity("Product", $model->productID, 'delete', $model->name_ru);
                $notify = new UserNotifications;
                $notify->putMassNotify(\Yii::$app->user->id, "Удалил продукт $model->name_ru");

                $this->redirect(['/categories/']);
            }
        }*/
        Trash::add($model);
        $this->redirect(['/categories/']);



        return 'Ошибка доступа';
    }

    public function actionUploadimage($id){
        //$model = new SCProductPictures;
        $prior = SCProductPictures::find()->where("productID = $id")->orderBy("priority DESC")->one();
        if(!empty($prior)){
            $newPriority = $prior->priority + 1;
        } else {
            $newPriority = 0;
        }

        $base_path = Yii::getAlias('@frontend');

        $image = UploadedFile::getInstanceByName('pic');
        if(!empty($image)){
            $filename = explode(".", $image->name);
            $ext = $filename[1];
            $newname = Yii::$app->security->generateRandomString(26);
            $pic = $newname.".{$ext}";
            $path = $base_path . '/web/img/products_pictures/' .$newname.'_enl.'.$ext;
            $image->saveAs($base_path . '/web/img/products_pictures/'.$newname.'_enl.'.$ext, ['quality' => 80]);

            Image::thumbnail($path, 150, 150)
                ->save($base_path . '/web/img/products_pictures/'.$newname.'_thm.'.$ext, ['quality' => 80]);

            Image::thumbnail($path, 300, 300)
                ->save($base_path . '/web/img/products_pictures/'.$newname.'.'.$ext, ['quality' => 80]);

            $file = array();
            $file['name'] = $pic;
            $file['url'] = \Yii::$app->urlManagerFrontend->createAbsoluteUrl("/img/upload/".$pic);
            $file['thumbnailUrl'] = \Yii::$app->urlManagerFrontend->createAbsoluteUrl("/img/upload/".$pic);

            $files = array();
            $files['files'][] = $file;

            $model = new SCProductPictures;
            $model->filename = $pic;
            $model->thumbnail = $newname.'_thm.'.$ext;
            $model->enlarged = $newname.'_enl.'.$ext;
            $model->productID = $id;
            $model->priority = $newPriority;
            $model->save();

            return json_encode($files);
        }

    }

    public function actionReloadimages(){
        $id =$_POST['prd'];
        $model = SCProducts::find()->where('productID = '.$id)->one();
        return $this->renderAjax('_productpictures', ['model'=>$model]);
    }

    public function actionRemoveimage($id, $ajax = 1){
        $model = SCProductPictures::find()->where("photoID = $id")->one();
        $productID = $model->productID;
        $model->delete();
        if($ajax == 0){
            $this->redirect(['/categories/editproduct', 'id'=>$productID]);
        }
    }

    public function actionLoadattrs(){
        $id = $_POST['id'];
        $model = SCProductOptions::find()->where("optionCategory = $id")->all();
        return $this->renderAjax('_options_external', ['model'=>$model]);
    }

    public function actionDeleteType() {
        $id = $_POST['id'];

        SCProducts::findOne($id)->updateAttributes([
            'attr_cat' => null
        ]);

        SCProductOptionsValues::deleteAll([
            'productID' => $id
        ]);

        //delete MongoAttrs
        $mongoAttrs = ProductAttributes::find()
            ->where(['product_id' => (int)$id])
              ->one();

        if ($mongoAttrs) {
            $mongoAttrs->params = [];
            $mongoAttrs->save();
        }
        //end delete MongoAttrs

        $this->redirect([
            '/categories/editproduct?id=' . $id
        ]);
    }

    public function actionAx($q){
        $ar = array();

        $lookProducts = SCProducts::find()->where(['like' , 'name_ru', $q])->orWhere(['like' , 'product_code', $q])->asArray()->all();
        $productData = array();
        foreach($lookProducts as $lp){
            $productData[] = ['name'=>$lp['name_ru'], 'link'=>Url::to(['/categories/editproduct','id'=>$lp['productID']]), 'type'=>'Продукт'];
        }
        $lookCategories =  SCCategories::find()->where(['like' , 'name_ru', $q])->asArray()->all();
        $categoryData = array();
        foreach($lookCategories as $lc){
            $categoryData[] = ['name'=>$lc['name_ru'], 'link'=>Url::to(['/categories/update','id'=>$lc['categoryID']]), 'type'=>'Категория'];
        }


        $ar = ArrayHelper::merge($ar, $productData, $categoryData);
        $nar = array();
        foreach($ar as $v){
            $nar[] = ['value' => $v['name'], 'link'=>$v['link'], 'type'=>$v['type']];
        }
        $json = Json::encode($nar);
        echo $json;
    }

    public function actionResortImages(){
        $id = $_POST['id'];
        $priority = $_POST['priority'];
        $model = SCProductPictures::find()->where("photoID = $id")->one();
        $model->priority = $priority;
        $model->save();
    }

    public function actionSetSort()
    {
        $id = $_POST['id'];
        $priority = $_POST['priority'];
        $model = SCCategories::find()->where("categoryID = $id")->one();
        if($model->parent == 1){
            $model->main_sort = $priority;
        } else {
            $model->sort_order = $priority;
        }
        if(!$model->save()){
            print_r($model->getErrors());
        }
    }

    public function actionSetSortProducts()
    {
        $id = $_POST['id'];
        $priority = $_POST['priority'];
        $model = SCProducts::find()->where("productID = $id")->one();
        $model->sort_order = $priority;
        if(!$model->save()){
            print_r($model->getErrors());
        }
    }

    public function actionSetNew()
    {
        $id = $_GET['id'];
        $model = SCCategories::findOne($id);
        foreach($model->products as $product){
            $product->showNew = 1;
            if(!$product->save(false)){
                echo 'asd';
            }
        }
        return true;
    }

    public function actionUnsetNew()
    {
        $id = $_GET['id'];
        $model = SCCategories::findOne($id);
        foreach($model->products as $product){
            $product->showNew = 0;
            if(!$product->save(false)){
                echo 'asd';
            }
        }
        return true;
    }

    public function actionLoadMoveModal()
    {
        $val = $_POST['val'];
        return $this->renderAjax('_select_to_move_modal', ['val'=>$val]);
    }

    public function actionMoveProducts()
    {
        $data = $_POST['Move'];
        $newParent = $_POST['newParent'];
        $oldParent = '';
        $products = [];
        foreach ($data as $k=>$d){
            if($d == 1){
                $model = SCProducts::findOne($k);
                $products[] = $model;
                $oldParent = $model->categoryID;
            }
        }

        foreach ($products as $p){
            $p->categoryID = $newParent;
            if(!$p->save(false)){
                print_r($p->getErrors());
            }
        }

        $retVal = [];
        $retVal['count'] = count($products);
        $retVal['samecat'] = $oldParent==$newParent?'true':'false';

        echo Json::encode($retVal);
        return;
    }


}
