<?php

namespace backend\modules\content\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;
use common\models\SCArticlesTournaments;
use common\models\SCArticlesTournamentsSearch;

/**
 * ArticleTourController implements the CRUD actions for SCArticlesTournaments model.
 */
class ArticleTourController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => 'http://rybalkashop.ru/img/newscontent/', // Directory URL address, where files are stored.
                'path' => Yii::getAlias('@frontend/web/img/articletournaments') // Or absolute path to directory where files are stored.
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulkdelete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all SCArticlesTournaments models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!empty($_POST['sort_id']) && !empty($_POST['sort_value'])) {
            $model = SCArticlesTournaments::findOne($_POST['sort_id']);

            $model->sort_order = $_POST['sort_value'];

            $model->save(false);
        }

        $searchModel = new SCArticlesTournamentsSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SCArticlesTournaments model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title'=> "SCArticlesTournaments #".$id,
                'content'=>$this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]). Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new SCArticlesTournaments model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;

        $model = new SCArticlesTournaments();

        if ($request->isAjax) {
            //Process for ajax request
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->isGet) {
                return [
                    'title' => "Create new SCArticlesTournaments",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]). Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new SCArticlesTournaments",
                    'content' => '<span class="text-success">Create SCArticlesTournaments success</span>',
                    'footer' => Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]). Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new SCArticlesTournaments",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]). Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        } else {
            //Process for non-ajax request
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->NID]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing SCArticlesTournaments model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

        $model = $this->findModel($id);

        if($request->isAjax){
            //Process for ajax request
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->isGet) {
                return [
                    'title'=> "Update SCArticlesTournaments #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]). Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "SCArticlesTournaments #".$id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]). Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update SCArticlesTournaments #".$id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]). Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        } else {
            //Process for non-ajax request
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->NID]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing SCArticlesTournaments model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            //Process for ajax request
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            //Process for non-ajax request
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing SCArticlesTournaments model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionBulkdelete()
    {        
        $request = Yii::$app->request;

        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys

        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            //Process for ajax request
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        } else {
            //Process for non-ajax request
            return $this->redirect(['index']);
        }
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionFileUpload()
    {
        $image = UploadedFile::getInstanceByName('SCArticlesTournaments[picture]');

        if (!empty($image)) {
            $filename = explode(".", $image->name);

            $newname = \Yii::$app->security->generateRandomString(26).'_'.$image->name;

            $pic = $newname;

            $path = Yii::getAlias('@frontend/web/img/articletournaments/') . $pic;

            $image->saveAs($path);

            return '{"name":"/img/articletournaments/'.$pic.'"}';
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the SCArticlesTournaments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SCArticlesTournaments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SCArticlesTournaments::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
