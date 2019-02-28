<?php

namespace common\models;

use Yii;
use karpoff\icrop\CropImageUploadBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "SC_experts".
 *
 * @property integer $expert_id
 * @property integer $shop_id
 * @property string $expert_name
 * @property string $expert_last_name
 * @property string $mini_description
 * @property string $full_text
 * @property string $picture
 * @property string $title
 * @property string $blog_picture
 * @property string $shop
 * @property string $expert_fullname
 * @property int $pair
 * @property int $gang
 * @property string $email [varchar(255)]
 * @property int $is_online [int(11)]
 * @property int $sort_order [int(11)]
 * @property int $user_id [int(11)]
 * @property string $phone [varchar(255)]
 * @property string $1c_id [varchar(255)]
 */
class SCExperts extends \yii\db\ActiveRecord
{
    const CAN_CONSULT = 1;

    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_experts';
    }

    /**
     * @return \yii\db\Connection|object
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
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['mini_description', 'full_text', 'email'], 'string'],
            ['picture', 'file', 'extensions' => 'jpeg, gif, png, jpg'],
            [['shop_id', 'gang', 'pair'], 'integer'],
            [['expert_name', 'expert_last_name', 'title', 'blog_picture', 'shop', 'expert_fullname'], 'string', 'max' => 255],
        ];
    }

    function behaviors()
    {
        return [
            [
                'class' => CropImageUploadBehavior::className(),
                'attribute' => 'picture',
                'path' => Yii::getAlias('@frontend/web/img/experts'),
                'url' => 'http://rybalkashop.ru/img/experts',
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
            'expert_id' => 'Expert ID',
            'expert_name' => 'Имя',
            'expert_last_name' => 'Фамилия',
            'mini_description' => 'Краткое описание',
            'full_text' => 'Полный текст',
            'picture' => 'Изображение',
            'title' => 'Title',
            'blog_picture' => 'Blog Picture',
            'shop' => 'Магазин',
            'expert_fullname' => 'Expert Fullname',
        ];
    }

    /**
     * @return SCExpertMessages
     */
    public function getMessages()
    {
        $model = SCExpertMessages::find()
            ->where(['expert_id' => $this->expert_id])
              ->all();

        return $model;
    }

    /**
     * @return SCShops|null
     */
    public function getShopObj()
    {
        return SCShops::findOne($this->shop_id);
    }

    /*
    public function afterSave($insert, $attrs)
    {
        $this->title = $this->expert_name . ' ' . $this->expert_last_name;
        $this->expert_fullname = $this->expert_name . ' ' . $this->expert_last_name;

        $this->save();
    }
    */
}
