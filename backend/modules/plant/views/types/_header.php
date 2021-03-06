<?php
use common\models\SCProducts;


$countPrds = SCProducts::find()->count();
$countGood = SCProducts::find()->where("attr_cat <> ''")->count();
?>

<div class="info-box bg-yellow">
    <span class="info-box-icon">%</span>
    <div class="info-box-content">
        <span class="info-box-text">Процент заполнения типов товаров</span>
        <span class="info-box-number"><?=Yii::$app->formatter->asInteger($countGood)?> из <?=Yii::$app->formatter->asInteger($countPrds)?></span>
        <div class="progress">
            <div class="progress-bar" style="width: <?=str_replace(',','.',Yii::$app->formatter->asDecimal($countGood*100/$countPrds));?>%"></div>
        </div>
                  <span class="progress-description">
                    <?=Yii::$app->formatter->asDecimal($countGood*100/$countPrds);?>%
                  </span>
    </div><!-- /.info-box-content -->
</div>



