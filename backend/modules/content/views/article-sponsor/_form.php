<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use vova07\imperavi\Widget;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use dosamigos\fileupload\FileUploadUI;
use kartik\switchinput\SwitchInput;


/* @var $this yii\web\View */
/* @var $model backend\models\SCNewsTable */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scnews-table-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'title_ru') ?>

    <div style="display: none">
        <?php if($model->isNewRecord){
            echo $form->field($model, 'add_date')->hiddenInput(['value'=>date('d.m.Y H:i:s', time()+14400)]);
        }?>
    </div>
    <?= $form->field($model, 'brand')->dropDownList(ArrayHelper::map(\common\models\SCMonufacturers::find()->orderBy("name ASC")->all(), 'id', 'name'), ['prompt'=>'Выбрать бренд']) ?>

    <?php echo $form->field($model, 'picture')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'value'=>(!$model->isNewRecord?$model->picture:""),
        'pluginOptions' => [
            'initialPreview'=>empty($model->picture)?false:[Html::img("http://rybalkashop.ru".$model->picture,  ['class'=>'file-preview-image', 'alt'=>'The Earth', 'title'=>'The Earth'])],
            'initialCaption'=>$model->picture,
            'overwriteInitial'=>true,
            'showRemove' => false,
            'showUpload' => true,
            'browseLabel' =>  'Загрузить',
            'uploadUrl' => Url::to(['/content/article-sponsor/file-upload']),
        ],
        'pluginEvents' => [
            'fileuploaded' => 'function(event, key) { $(".field-scarticlessponsorship-picture > input").val(key.response.name); }',
        ]
    ]); ?>

    <?= $form->field($model, 'textToPublication_ru')->widget(Widget::className(), [
        'settings' => [
            'imageUpload' => Url::to(['/news/image-upload']),
            'lang' => 'ru',
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen'
            ]
        ]
    ]); ?>

    <?= $form->field($model, 'textMini')->widget(Widget::className(), [
        'settings' => [
            'imageUpload' => Url::to(['/news/image-upload']),
            'lang' => 'ru',
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen'
            ]
        ]
    ]); ?>

    <?php echo $form->field($model, 'published')->widget(SwitchInput::classname(),[
        'pluginOptions'=>[
            'onText'=>'Да',
            'offText'=>'Нет'
        ]
    ])->label('Публиковать?'); ?>

    <?php echo $form->field($model, 'tpl')->dropDownList([''=>'Стандартный', 'black'=>'Черный'])->label('Шаблон'); ?>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>

<?php $js = <<<JS
$(function(){
    $('input[name="SCArticlesSponsorship[picture]"]').attr('value',$('#scnewstable-picture').attr('value'));
});
JS;
$this->registerJs($js);
?>
