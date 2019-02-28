<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_product_options_values".
 *
 * @property integer $optionID
 * @property integer $productID
 * @property integer $option_type
 * @property integer $option_show_times
 * @property integer $variantID
 * @property string $option_value_en
 * @property string $option_value_ru
 */
class SCProductOptionsValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $optionName;

    public static function tableName()
    {
        return 'SC_product_options_values';
    }

    /**
     * @return \yii\db\Connection|object the database connection used by this AR class.
     * @throws \yii\base\InvalidConfigException
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
            [['optionID', 'productID'], 'required'],
            [['optionID', 'productID', 'option_type', 'option_show_times', 'variantID'], 'integer'],
            [['option_value_en', 'option_value_ru'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'optionID' => 'Option ID',
            'productID' => 'Product ID',
            'option_type' => 'Option Type',
            'option_show_times' => 'Option Show Times',
            'variantID' => 'Variant ID',
            'option_value_en' => 'Option Value En',
            'option_value_ru' => 'Option Value Ru',
        ];
    }

    public static function primaryKey(){
        return array('optionID', 'productID');
    }

    public function afterFind(){
        $cache = Yii::$app->cache;

        $key = "option_category_options_af_" . $this->optionID;

        $data = $cache->get($key);

        if ($data === false) {
            $data = SCProductOptions::find()
                ->where("optionID = $this->optionID")
                  ->one();

            $cache->set($key, $data, 99999);
        }

        if (!empty($data)) {
            $this->optionName = $data->name_ru;
        }

        if ($this->option_value_ru == 'yes') $this->option_value_ru = "Да";
        if ($this->option_value_ru == 'no') $this->option_value_ru = "Нет";
    }

    public function getOption() {
        return $this->hasOne(SCProductOptions::className(), ['optionID' => 'optionID']);
    }
}
