<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_product_pictures".
 *
 * @property integer $photoID
 * @property integer $productID
 * @property string $filename
 * @property string $thumbnail
 * @property string $enlarged
 * @property integer $priority
 */
class SCProductPictures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_product_pictures';
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
            [['productID', 'priority'], 'integer'],
            [['filename', 'thumbnail', 'enlarged'], 'string', 'max' => 255],
        ];
    }

    public function getLargest()
    {
        if(!empty($this->enlarged))return $this->enlarged;
        return $this->filename;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'photoID' => 'Photo ID',
            'productID' => 'Product ID',
            'filename' => 'Filename',
            'thumbnail' => 'Thumbnail',
            'enlarged' => 'Enlarged',
            'priority' => 'Priority',
        ];
    }
}
