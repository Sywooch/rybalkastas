<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;

/* @var $this yii\web\View */
/* @var $searchModel \common\models\SCReviewTableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список обзоров';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<div class="scnews-table-index">
    <div id="ajaxCrudDatatable">
        <?php try {
            echo GridView::widget([
                'id' => 'crud-datatable',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pjax' => true,
                'columns' => require(__DIR__ . '/_columns.php'),
                'toolbar' => [
                    ['content' =>
                        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], [
                            'role' => 'modal-remote', 'title' => 'Добавить новость', 'class' => 'btn btn-default'
                        ]) .
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], [
                            'data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Сбросить фильтры'
                        ]) .
                        '{toggleData}' .
                        '{export}'
                    ],
                ],
                'striped' => true,
                'condensed' => true,
                'responsive' => true,
                'panel' => [
                    'type' => 'primary',
                    'heading' => '<i class="glyphicon glyphicon-list"></i> Новости',
                    'before' => '<em>* Размеры ячеек можно растягивать как в Excel.</em>',
                ]
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        } ?>
    </div>
</div>

<?php Modal::begin([
    'id' => 'ajaxCrubModal',
    'size' => 'modal-lg',
    'footer' => '',
])?>
<?php Modal::end(); ?>


