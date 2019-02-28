<?php

namespace common\models;

use Yii;
use common\models\SCParsingProductsSearch;
use common\models\SCRivalProducts;
use common\models\SCRivalProductSearch;
use yii\db\ActiveRecord;
use common\models\SCProductsParsing;
use common\models\SCProducts;
use GuzzleHttp\Client;
use common\models\SCParsingSearch;
/**
 * This is the model class for table "SC_parsing".
 *
 * @property int $id
 * @property string $price
 * @property string $name
 * @property string $link

 */
class SCParsing extends ActiveRecord
{


    public static function tableName()
    {
        return 'sc_parsing';
    }


    public function getProducts()
    {
        return $this
            ->hasMany(SCProducts::className(), ['productID' => 'product_id'])
            ->viaTable('sc_products_parsing', ['parsing_id' => 'id']);
    }

    public function getNameRu()
    {
        return $this->hasMany(SCProducts::className(), ['name_ru' => 'product_name'])
            ->viaTable('sc_products_parsing', ['product_name' => 'name']);
    }


    public function rules()
    {
        return [
//            ['link'], 'string',
//            ['price'], 'double',
            ['name', 'unique'],

        ];
    }



    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'link' => 'link',
            'price' => 'price',
        ];
    }



}