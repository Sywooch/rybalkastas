<?php

namespace backend\modules\content\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\helpers\Json;
use yii\filters\VerbFilter;
use Imagine\Image\Box;
use Imagine\Image\Point;
use common\models\SCMainpage;
use common\models\SCMonufacturers;
use common\models\SCSlider1;

class SliderController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'remove' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = SCSlider1::find()
              ->where(['!=', 'deleted_at', SCSlider1::getDeletedStatusValue()])
            ->orderBy(['disabled' => SORT_ASC, 'sort_order' => SORT_ASC])
                ->all();

        foreach ($model as $m) {
            $path = Yii::getAlias('@frontend/web/img/slider/') . $m->image;
            $box = new Box(950, 200);

            $img = Image::getImagine()->open($path);
            $img->resize($box)
                ->save($path, ['quality' => 100]);
        }

        $newslide = new SCSlider1;

        return $this->render('index', [
            'model'    => $model,
            'newslide' => $newslide
        ]);
    }

    public function actionEdit($id)
    {
        if (!isset($_POST['SCSlider1'])) return false;

        $model = SCSlider1::find()
            ->where("id = $id")
              ->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return "Слайд сохранен";
        } else {
            return "Ошибка при сохранении";
        }
    }

    public function actionInsert()
    {
        if (!isset($_POST['SCSlider1'])) return false;

        $model = new SCSlider1;
        $model->scenario = 'insert';

        if ($model->load(Yii::$app->request->post())) {
            $model->offset_x = '1';
            $model->offset_y = '1';
            $model->bgcolor = "#ffffff";
            $model->txtcolor = "#000000";

            if($model->save()){
                return $this->redirect([
                    '/content/slider/index'
                ]);
            } else {
                print_r($model->getErrors());
            }
        }
    }

    public function actionRemove()
    {
        $result = false;

        $model = SCSlider1::find()
            ->where(['id' => $_POST['id']])
              ->one();

        if ($model) {
            $model->updateAttributes([
                'disabled'   => SCSlider1::getDisabledStatusValue(),
                'deleted_at' => SCSlider1::getDeletedStatusValue(),
            ]);

            $result = true;
        }

        return $result;
    }

    public function actionSort()
    {
        $id   = $_POST['id'];
        $sort = $_POST['sort'];

        $model = SCSlider1::find()
            ->where("id = $id")
              ->one();

        $model->sort_order = $sort;

        $model->save();

        return 'success';
    }
}
