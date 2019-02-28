<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 25.09.2017
 * Time: 14:52
 */

namespace backend\modules\reports\assets;


use yii\web\AssetBundle;

class ExpertsAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/reports/assets';
    public $js = [
        'js/experts_index.js'
    ];
    public $publishOptions = [
        'forceCopy'=>true,
    ];
}