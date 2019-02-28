<?php

namespace common\models\stack;

use Yii;

/**
 * This is the model class for table "stack_tasks".
 *
 * @property integer $id
 * @property integer $pack_id
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 * @property integer $assigned_to
 * @property string $object
 * @property integer $object_id
 * @property string $json_fields
 * @property string $json_meta_data
 * @property string $json_field_data
 * @property integer $status
 */
class StackTasks extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_CHECKING = 1;
    const STATUS_SENTBACK = 2;
    const STATUS_APPROVED = 3;
    const STATUS_CANCELED = 4;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stack_tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pack_id', 'assigned_to', 'object_id', 'status'], 'integer'],
            [['json_fields', 'json_meta_data', 'json_field_data'], 'string'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'object'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pack_id' => 'Pack ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'assigned_to' => 'Assigned To',
            'object' => 'Object',
            'object_id' => 'Object ID',
            'json_fields' => 'Json Fields',
            'json_meta_data' => 'Json Meta Data',
            'json_field_data' => 'Json Field Data',
            'status' => 'Status',
        ];
    }

    public function getEntity()
    {
        $object = $this->object;
        $model = forward_static_call([$object, 'findOne'], $this->object_id);
        return $model;
    }
}
