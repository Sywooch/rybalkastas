<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "SC_shop_ratings".
 *
 * @property integer $rating_id
 * @property integer $user_id
 * @property string $content_text
 * @property string $rating
 * @property integer $approved
 * @property string $response_text
 * @property string $response_date
 * @property integer $hidden
 * @property int $created_at
 * @property int $updated_at
 */
class SCShopRatings extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_shop_ratings';
    }

    /**
     * @return \yii\db\Connection
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
            [['user_id', 'content_text'], 'required'],
            [['user_id', 'approved', 'hidden'], 'integer'],
            [['content_text', 'response_text'], 'string'],
            [['date', 'response_date'], 'safe'],
            [['rating'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rating_id' => 'Rating ID',
            'user_id' => 'User ID',
            'content_text' => 'Content Text',
            'rating' => 'Rating',
            'date' => 'Date',
            'approved' => 'Approved',
            'response_text' => 'Ответ',
            'response_date' => 'Response Date',
            'hidden' => 'Hidden',
        ];
    }

    public function getUser(){
        $model = SCCustomers::find()
            ->where(['customerID' => $this->user_id])
              ->one();

        return $model;
    }

    public function getDateform(){
        if (date('Y-m-d') == date('Y-m-d', $this->created_at)) {
            return 'Сегодня в ' . Yii::$app->formatter->asTime($this->created_at, 'php:H:i');
        } elseif (date('Ymd', $this->created_at) == date('Ymd', strtotime('yesterday'))) {
            return 'Вчера в ' . Yii::$app->formatter->asTime($this->created_at, 'php:H:i');
        } else {
            if (date('Y') > date('Y', $this->created_at)) {
                return $this->replaceMonth(Yii::$app->formatter->asDatetime($this->created_at, 'php:d F Y в H:i'));
            } else {
                return $this->replaceMonth(Yii::$app->formatter->asDatetime($this->created_at, 'php:d F в H:i'));
            }
        }
    }

    public function getNormalDate(){
        return date('d-m-Y', strtotime($this->date));
    }

    function replaceMonth($date){
        $date = str_replace('January', 'Января', $date);
        $date = str_replace('February', 'Февраля', $date);
        $date = str_replace('March', 'Марта', $date);
        $date = str_replace('April', 'Апреля', $date);
        $date = str_replace('May', 'Мая', $date);
        $date = str_replace('June', 'Июня', $date);
        $date = str_replace('July', 'Июля', $date);
        $date = str_replace('August', 'Августа', $date);
        $date = str_replace('September', 'Сентября', $date);
        $date = str_replace('October', 'Октября', $date);
        $date = str_replace('November', 'Ноября', $date);
        $date = str_replace('December', 'Декабря', $date);

        return $date;
    }

    public function getStars()
    {
        $rating = $this->rating;
        switch ($rating) {
            case '0':
                return '<i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                break;
            case '0.5':
                return '
          <i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                break;
            case '1':
                return '
          <i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                break;
            case '1.5':
                return '
          <i class="fa fa-star"></i>
          <i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                break;
            case '2':
                return '
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                break;
            case '2.5':
                return '
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                break;
            case '3':
                return '
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                break;
            case '3.5':
                return '
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i>';
                break;
            case '4':
                return '
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i><i class="fa fa-star-o"></i>';
                break;
            case '4.5':
                return '
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star-half-o"></i>';
                break;
            case '5':
                return '
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>';
                break;
        }
    }
}
