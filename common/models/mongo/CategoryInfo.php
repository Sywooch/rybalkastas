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
class CategoryInfo extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['rybalkashop', 'categoryInfo'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'category_id',
            'name',
            'description',
            'picture',
            'parent'
        ];
    }


}
