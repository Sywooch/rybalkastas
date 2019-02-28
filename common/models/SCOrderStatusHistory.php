<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_order_status_history".
 *
 * @property integer $orderID
 * @property integer $statusID
 * @property string $time
 */
class SCOrderStatusHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_order_status_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderID', 'statusID'], 'required'],
            [['orderID', 'statusID','time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'orderID' => 'Order ID',
            'statusID' => 'Status ID',
            'time' => 'Time',
        ];
    }
}
