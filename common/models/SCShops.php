<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_shops".
 *
 * @property int $shopID
 * @property string $name
 * @property string $id_1c
 * @property string $phone
 * @property string $slug
 */
class SCShops extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SC_shops';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'id_1c', 'phone', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'shopID' => 'Shop ID',
            'name' => 'Name',
            'id_1c' => 'Id 1c',
            'phone' => 'Phone',
        ];
    }
}
