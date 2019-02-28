<?php

namespace common\models\mongo;

use Yii;

/**
 * Class ProductAttributes
 * @package common\models\mongo
 * @property  int $product_id
 * @property  array $params
 */
class ProductAttributes extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return [
            'rybalkashop',
            'product_attributes',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'product_id',
            'params',
        ];
    }
}
