<?php

namespace common\models\mongo;

use Yii;

/**
 * This is the model class for collection "userMeta".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $user_id
 * @property mixed $product_views
 */
class ProductInfo extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['rybalkashop', 'productInfo'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'product_id',
            'category_id',
            'name',
            'pictures',
            'price',
            'old_price',
            'discount_percent',
            'in_stock',
            'in_stock_provider',
            'monufacturer',
            'description',
            'params',
            'market'
        ];
    }


}
