<?php
use common\models\SCProducts;


$countAttrs = \common\models\SCProductOptionsValues::find()->count();
$countEmpty = \common\models\SCProductOptionsValues::find()->where("option_value_ru = ''")->count();
?>

<div class="info-box bg-red-gradient">
    <span class="info-box-icon">!</span>
    <div class="info-box-content">
        <span class="info-box-text">Процент пустых атрибутов</span>
        <span class="info-box-number"><?=Yii::$app->formatter->asInteger($countEmpty)?> из <?=Yii::$app->formatter->asInteger($countAttrs)?></span>
        <div class="progress">
            <div class="progress-bar" style="width: <?=str_replace(',','.',Yii::$app->formatter->asDecimal($countEmpty*100/$countAttrs));?>%"></div>
        </div>
                  <span class="progress-description">
                    <?=Yii::$app->formatter->asDecimal($countEmpty*100/$countAttrs);?>%
                  </span>
    </div><!-- /.info-box-content -->
</div>



