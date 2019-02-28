<?php

namespace backend\controllers;

use Yii;
use common\models\SCReviewTable;
use common\models\SCReviewTableSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;

/**
 * ReviewController implements the CRUD actions for SCReviewTable model.
 */
class ReviewController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SCReviewTable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SCReviewTableSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SCReviewTable model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SCReviewTable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SCReviewTable();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if (Yii::$app->request->isGet) {
                return [
                    'title' => 'Создать обзор',
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) . Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => 'submit'])

                ];
            } elseif ($model->load(Yii::$app->request->post()) && $model->save()) {
                return [
                    'forceReload' => 'true',
                    'title'=> 'Создать обзор',
                    'content' => '<span class="text-success">Обзор успешно создан</span>',
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) . Html::a('Создать еще', ['create'], ['class' => 'btn btn-primary','role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => 'Создать обзор',
                    'content' => $this->renderPartial('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) . Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect([
                    'view', 'id' => $model->id
                ]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing SCReviewTable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if (Yii::$app->request->isGet) {
                return [
                    'title' => 'Обновить обзор - ' . $model->title_ru ,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть', ['class' => 'btn btn-default pull-left','data-dismiss' => 'modal']) . Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return [
                    'forceReload' => 'true',
                    'title' => 'Обзор - ' . $model->title_ru,
                    'content' => $this->renderPartial('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) . Html::a('Редактировать', ['update','id' => $id], ['class' => 'btn btn-primary','role' => 'modal-remote'])
                ];
            }else{
                return [
                    'title' => 'Обзор - ' . $model->title_ru,
                    'content' => $this->renderPartial('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) . Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Deletes an existing SCReviewTable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SCReviewTable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SCReviewTable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SCReviewTable::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
