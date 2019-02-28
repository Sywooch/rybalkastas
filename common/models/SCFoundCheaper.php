<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_found_cheaper".
 *
 * @property integer $id
 * @property integer $customerID
 * @property integer $productID
 * @property string $url
 */
class SCFoundCheaper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_found_cheaper';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customerID', 'productID', 'url'], 'required'],
            [['customerID', 'productID'], 'integer'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'customerID' => 'Покупатель',
            'productID' => 'Товар',
            'url' => 'Ссылка',
        ];
    }
}
