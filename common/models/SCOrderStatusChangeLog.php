<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_order_status_changelog".
 *
 * @property integer $orderID
 * @property string $status_name
 * @property string $status_change_time
 * @property string $status_comment
 */
class SCOrderStatusChangeLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_order_status_changelog';
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
            [['orderID'], 'integer'],
            [['status_change_time'], 'safe'],
            [['status_comment'], 'string'],
            [['status_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'orderID' => 'Order ID',
            'status_name' => 'Status Name',
            'status_change_time' => 'Status Change Time',
            'status_comment' => 'Status Comment',
        ];
    }
}
