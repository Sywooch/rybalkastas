<?php
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;

?>
<?php foreach($model->pictures as $pic):?>

    <div class="image sortable file-preview-frame" data-id="<?=$pic->photoID;?>" data-order="<?=$pic->priority;?>">
        <div class="removeicon">
            <?php
            $form = ActiveForm::begin([
                'method' => 'get',
                'action' => Url::to(['categories/removeimage']),
                'options' => [
                   'class' => 'imgremover'
                ]
            ]);
            ?>
                <input type="hidden" name="id" value="<?=$pic->photoID;?>" />
                <input type="hidden" class="isAjax" name="ajax" value="0" />
                <button type="submit">
                    <span class="fa-stack fa-lg">
                      <i style="color: red;" class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                    </span>
                </button>
            <?php ActiveForm::end(); ?>
        </div>
        <img class="file-preview-image" src="<?=\Yii::$app->urlManagerFrontend->createAbsoluteUrl("/img/products_pictures/$pic->thumbnail")?>">
    </div>
<?php endforeach;?>