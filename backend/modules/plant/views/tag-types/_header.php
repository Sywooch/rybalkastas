<?php
use common\models\SCProducts;


$countPrds = SCProducts::find()->count();
$countGood = SCProducts::find()->where("attr_cat <> ''")->count();
?>



