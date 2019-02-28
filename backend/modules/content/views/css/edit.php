<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 30.11.2015
 * Time: 15:18
 */
use conquer\codemirror\CodemirrorWidget;
use conquer\codemirror\CodemirrorAsset;
use yii\widgets\ActiveForm;

$this->title = $model->name;
?>
<?php if(!empty($backups)):?>
<div class="col-md-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            <i class="fa fa-cogs"></i>
            <h3 class="box-title">Прежние версии этого файла:</h3>
        </div><!-- /.box-header -->
        <div class="box-body" id="actions">
            <?php foreach($backups as $b):?>
                <div class="col-md-2">
                    <a href="<?=\yii\helpers\Url::to(["/content/css/edit", 'id'=>$b->id]);?>" class="btn btn-app">
                        <i class="fa fa-cogs"></i> <?=$b->description;?>
                    </a>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<?php endif;?>

<div class="col-md-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            <i class="fa fa-cogs"></i>
            <h3 class="box-title">Редактирование <?=$model->name?> <small><?=$model->description?></small></h3>
        </div><!-- /.box-header -->
        <div class="box-body" id="actions">
            <?php $form = ActiveForm::begin(); ?>
            <?=CodemirrorWidget::widget([
                'name'=>'data',
                'value'=>$data,
                'options'=>['height'=>'auto'],
                'assets'=>[
                    CodemirrorAsset::MODE_CSS,
                    CodemirrorAsset::THEME_PARAISO_DARK,
                ],
                'settings'=>[
                    'theme' => 'paraiso-dark',
                    'rows' => 120,
                ],
            ]);

            ?>
            <input class="savecss btn btn-default" type="submit" value="Сохранить">
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<style>
    .CodeMirror {
        border: 1px solid #eee;
        height: auto;
    }

    .savecss{
        position: fixed;
        top: 34%;
        right: 3%;
        z-index: 9999;
    }
</style>


