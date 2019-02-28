<?php

namespace common\models;

use Yii;
use Imagine\Image\Point;
use karpoff\icrop\CropImageUploadBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "SC_sidebarbrands".
 *
 * @property integer $id
 * @property string $picture
 * @property string $link
 * @property integer $order
 * @property string $text
 */
class SCSidebarbrands extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_sidebarbrands';
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
            [['picture'], 'required'],
            ['picture', 'file', 'extensions' => 'jpeg, gif, png, jpg', 'on' => ['insert', 'update']],
            [['link', 'order'], 'required'],
            [['order'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['link'], 'string', 'max' => 300],
        ];
    }

    function behaviors()
    {
        return [
            [
                'class' => CropImageUploadBehavior::className(),
                'attribute' => 'picture',
                'scenarios' => ['insert', 'update'],
                'path' => Yii::getAlias('@frontend/web/img/brandlogos/JPEG/'),
                'url' => 'http://rybalkashop.ru/img/brandlogos/JPEG/',
                'ratio' => 2/1.1,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'picture' => 'Изображение',
            'link' => 'Ссылка',
            'order' => 'Order',
            'text' => 'Text',
        ];
    }

    function scenarios() {
        return array(
            'insert' => array('picture','link','order','text'),
            'sort' => array('order'),
            'edit'=> array('link','picture'),
        );
    }

    public function afterFind()
    {
        $parts = parse_url($this->link);
        parse_str($parts['query'], $query);
        if (strpos($this->link, 'static') !== false){
            $this->link = Url::to(['/brands/index', 'alias'=>$query['static']]);
        } elseif (strpos($this->link, 'categoryID') !== false){
            $this->link = Url::to(['/shop/category', 'id'=>$query['categoryID']]);
        }
        parent::afterFind(); // TODO: Change the autogenerated stub
    }
}