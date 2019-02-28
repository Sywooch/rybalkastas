<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use common\components\UtUploader;
use common\models\SCCustomers;
use common\models\SCOrders;
use common\models\SCOrdersSearch;
use common\services\Ordering1cService;

/**
 * OrdersController
 */
class OrdersController extends Controller
{
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
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {    
        $searchModel = new SCOrdersSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id, $print = false)
    {   
        $request = Yii::$app->request;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title'   => "Заказ №" . sprintf("%08d", $id),
                'content' => $this->renderPartial('view', [
                    'model' => $this->findModel($id),
                    'ajax'  => $request->isAjax,
                    'print' => $print
                ]),
                'footer'=> Html::button('Закрыть',[
                    'class'        =>'btn btn-default pull-left',
                    'data-dismiss' =>"modal"
                ])
            ];
        } else {
            if ($print) {
                $this->layout = 'print';
            }

            return $this->render('view', [
                'model' => $this->findModel($id),
                'ajax'  => $request->isAjax,
                'print' => $print
            ]);
        }
    }

    public function actionUser($id){
        $user = SCCustomers::find()
            ->where("customerID = $id")
              ->one();

        return $this->render('user', [
            'model' => $user,
        ]);
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;

        $model = new SCOrders();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->isGet) {
                return [
                    'title'   => "Create new SCOrders",
                    'content' =>$this->renderPartial('create', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                                 Html::button('Save', ['class' => 'btn btn-primary', 'type' => 'submit'])
        
                ];         
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => 'true',
                    'title'       => "Create new SCOrders",
                    'content'     => '<span class="text-success">Create SCOrders success</span>',
                    'footer'      => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                                     Html::a('Create More', ['create'],['class' => 'btn btn-primary', 'role' => 'modal-remote'])
        
                ];         
            } else {
                return [
                    'title'   => "Create new SCOrders",
                    'content' => $this->renderPartial('create', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                                 Html::button('Save', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];         
            }
        } else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->orderID]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

        $model = $this->findModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->isGet) {
                return [
                    'title'   => "Update SCOrders #" . $id,
                    'content' => $this->renderPartial('update', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('Close', ['class' => 'btn btn-default pull-left','data-dismiss' => 'modal']) .
                                 Html::button('Save', ['class' => 'btn btn-primary','type' => 'submit'])
                ];         
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => 'true',
                    'title'       => "SCOrders #" . $id,
                    'content'     => $this->renderPartial('view', [
                        'model' => $model,
                        'ajax'  => $request->isAjax,
                        'print' => null,
                    ]),
                    'footer'    => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                                   Html::a('Edit',['update', 'id' => $id], ['class' => 'btn btn-primary','role' => 'modal-remote'])
                ];    
            } else {
                 return [
                    'title'   => "Update SCOrders #".$id,
                    'content' =>$this->renderPartial('update', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                                 Html::button('Save', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];        
            }
        }else{
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->orderID]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionDelete($id)
    {
        $request = Yii::$app->request;

        $this->findModel($id)->delete();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => true];
        } else {
            return $this->redirect(['index']);
        }
    }

    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;

        $pks = $request->post('pks'); // Array or selected records primary keys

        foreach (SCOrders::findAll(json_decode($pks)) as $model) {
            $model->delete();
        }

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => true];
        }else{
            return $this->redirect(['index']);
        }
    }

    public function actionUpload($id)
    {
        Ordering1cService::uploadOrderToUt($id);
    }

    public function actionRepair()
    {
        $id = 136337;
        $model = SCOrders::find()->where(['orderID'=>$id])->one();
        print_r($model->id_1c);
        $uploader = new UtUploader;
        print_r($uploader->RepairOrder($id));
    }

    public function actionOrderDelivery()
    {
        set_time_limit(1000);
        $array = [
            'Самовывоз - Братиславская',
            'Самовывоз - Молодежная',
            'Самовывоз - 16 км МКАД',
            'Самовывоз - Птичий рынок',
            'Самовывоз - Измайлово',
            'Самовывоз - Коньково',
            'Курьер',
            'Пункты самовывоза СДЭК',
            'Почта России',
            'EMS Почта России',
        ];
        $model = SCOrders::find()->select(['orderID', 'order_time', 'shipping_type'])->where(['in','shipping_type', $array])->orderBy(['orderID'=>SORT_DESC])->asArray()->all();
        return $this->render('order-delivery',['model'=>$model, 'array'=>$array]);
    }

    public function actionOrderDeliveryMonth($month){
        set_time_limit(1000);
        $array = [
            'Самовывоз - Братиславская',
            'Самовывоз - Молодежная',
            'Самовывоз - 16 км МКАД',
            'Самовывоз - Птичий рынок',
            'Самовывоз - Измайлово',
            'Самовывоз - Коньково',
            'Курьер',
            'Пункты самовывоза СДЭК',
            'Почта России',
            'EMS Почта России',
        ];
        $from = $month.'-01 00:00:00';
        $to = $month.'-31 23:59:59';
        $model = SCOrders::find()->select(['orderID', 'order_time', 'shipping_type'])->where(['in','shipping_type', $array])->andWhere(['between', 'order_time',$from,$to])->orderBy(['orderID'=>SORT_DESC])->asArray()->all();

        return $this->render('order-delivery-month', ['model'=>$model, 'array'=>$array]);
    }

    /**
     * Finds the SCOrders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SCOrders the loaded model
     * @return SCOrders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SCOrders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionOrdersByManager()
    {

    }
}
