<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SCOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="scorders-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    //Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    //['role'=>'modal-remote','title'=> 'Create new Scorders','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Список заказов',
                'before'=>'<em>* Размеры ячеек можно растягивать как в Excel.</em>',

            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrubModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<style>
    .modal-dialog {width:1200px;}
    #crud-datatable tr.highlight {background: #F37C00;}
    #crud-datatable tr.highlight td {
        color: #fff;
    }

    #crud-datatable tr.highlight a {
        color: #E1E4FD;
        text-decoration: underline;
    }
</style>

<script>
    var $key = $.cookie('highlightedOrder');
    $(function(){
        $.ajaxSetup({
           global:true
        });
        $('#crud-datatable tr[data-key='+$key+']').addClass('highlight');
    });

    $( document ).ajaxComplete(function() {
        $key = $.cookie('highlightedOrder');
        $('#crud-datatable tr[data-key='+$key+']').addClass('highlight');
    });

    $('#ajaxCrudDatatable').on('click','#crud-datatable tr',function(){
        $('#crud-datatable tr').removeClass('highlight');
        $(this).addClass('highlight');
        $.cookie('highlightedOrder', $(this).data('key'), {path: '/'});
        $key = $(this).data('key');
    });
</script>
