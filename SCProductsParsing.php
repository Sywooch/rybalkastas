<?php
/**
 * Created by PhpStorm.
 * User: Lakkinzi
 * Date: 2/5/2019
 * Time: 15:48
 */

namespace common\models;


use yii\db\ActiveRecord;
use common\models\SCParsing;
use common\models\SCProducts;
use Yii;
class SCProductsParsing extends ActiveRecord
{

    /**
     * This is the model class for table "SC_products_parsing".
     *
     * @property int $id
     * @property string $product_name
     * @property string $name
     * @property string $parsing_name
     * @property string $product_id
     * @property string $parsing_id

     */

    public static function tableName()
    {
        return 'sc_products_parsing';
    }

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public function rules()
    {
        return
        [
            [['parsing_id', 'product_id', 'id'], 'integer'],
            [['product_name', 'parsing_name'], 'string'],
        ];
    }

    public function getProductId()
    {
        return $this->hasMany(SCProducts::className(), ['productID' => 'product_id']);
    }

    public function getId()
    {
        return $this->hasMany(SCParsing::className(), ['id' => 'parsing_id']);
    }

    public function getName()
    {
        return $this->hasMany(SCParsing::className(), ['name' => 'parsing_name']);
    }


    public function getNameRu()
    {
        return $this->hasMany(SCProducts::className(), ['name_ru' => 'product_name']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'parsing_id' => 'parsing_id',
            'product_id' => 'product_id',
            'product_name' => 'product_name',
            'parsing_name' => 'parsing_name',

        ];
    }

}