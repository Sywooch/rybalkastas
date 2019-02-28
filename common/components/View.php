<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 09.06.2018
 * Time: 16:04
 */

namespace common\components;

use yii\web\View as BaseView;

class View extends BaseView {
    public function renderDynamic($statements,$additionalKey='')
    {
        if (!empty($this->cacheStack)) {
            $n = count($this->dynamicPlaceholders);
            $placeholder = "<![CDATA[YII-DYNAMIC-$n{$additionalKey}]]>";
            $this->addDynamicPlaceholder($placeholder, $statements);

            return $placeholder;
        } else {
            return $this->evaluateDynamicContent($statements);
        }
    }
}