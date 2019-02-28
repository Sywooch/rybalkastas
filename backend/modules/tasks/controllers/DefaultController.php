<?php

namespace backend\modules\tasks\controllers;

use common\models\stack\StackTaskPacks;
use common\models\stack\StackTasks;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Default controller for the `tasks` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $packs = StackTaskPacks::find()->all();
        return $this->render('index', ['packs'=>$packs]);
    }

    public function actionPack($id)
    {
        $model = StackTaskPacks::findOne($id);
        $query = StackTasks::find()->where(['pack_id'=>$id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);


        return $this->render('pack', ['dataProvider'=>$dataProvider, 'model'=>$model]);

    }
}
