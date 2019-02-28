<?php

namespace common\models;

use Yii;
use karpoff\icrop\CropImageUploadBehavior;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;

/**
 * This is the model class for table "SC_secondary_pages_links".
 *
 * @property integer $link_id
 * @property integer $page_id
 * @property integer $categoryID
 * @property string $mon_marker
 * @property string $tag_marker
 * @property string $custom_image
 */
class SCSecondaryPagesLinks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_secondary_pages_links';
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
            [['page_id'], 'required'],
            [['page_id', 'categoryID', 'link_type','sort_order', 'container_tmp'], 'integer'],
            [['mon_marker', 'tag_marker', 'custom_name', 'custom_link'], 'string', 'max' => 255],
            ['custom_image', 'file', 'extensions' => 'jpeg, gif, png, jpg', 'on' => ['insert', 'update']],
        ];
    }

    function behaviors()
    {
        return [
            [
                'class' => CropImageUploadBehavior::className(),
                'attribute' => 'custom_image',
                'scenarios' => ['insert', 'update'],
                'path' => Yii::getAlias('@frontend').'/web/img/products_pictures/',
                'url' => 'http://rybalkashop.ru/published/publicdata/TESTRYBA/attachments/SC/products_pictures/',
                'ratio' => 1/1,
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'link_id' => 'Link ID',
            'page_id' => 'Page ID',
            'categoryID' => 'Категория',
            'mon_marker' => 'Маркер производителя',
            'tag_marker' => 'Маркер тэга (через точку с запятой)',
            'custom_image' => 'Произвольное изображение',
            'custom_link' => 'Ссылка',
            'custom_name' => 'Произвольное название',
            'link_type' => 'Тип ссылки',
        ];
    }

    public function getCategory(){
        if($this->link_type == 0){
            if(!empty($this->categoryID)){
                return SCCategories::find()->where("categoryID = $this->categoryID")->one();
            }
        } else {
            return false;
        }
    }
}
