<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_ratings".
 *
 * @property integer $rating_id
 * @property integer $categoryID
 * @property integer $user_id
 * @property string $rating
 * @property integer $approved
 * @property string $date
 * @property string $comment_text
 * @property string $response_text
 * @property integer $hidden
 */
class SCRatings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_ratings';
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
            [['categoryID', 'user_id'], 'required'],
            [['categoryID', 'user_id', 'approved', 'hidden'], 'integer'],
            [['date'], 'safe'],
            [['comment_text', 'response_text'], 'string'],
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
            'categoryID' => 'Category ID',
            'user_id' => 'User ID',
            'rating' => 'Rating',
            'approved' => 'Approved',
            'date' => 'Date',
            'comment_text' => 'Comment Text',
            'response_text' => 'Response Text',
            'hidden' => 'Hidden',
        ];
    }

    public function getCategory(){
        $model = SCCategories::find()->where("categoryID = $this->categoryID")->one();
        return $model;
    }

    public function getUser(){
        $model = SCCustomers::find()->where("customerID = $this->user_id")->one();
        return $model;
    }

    public function getDateform(){
        if (date('Y-m-d') == date('Y-m-d', strtotime($this->date))) {
            return 'Сегодня в '.date('H:i', strtotime($this->date));
        } elseif(date('Ymd', strtotime($this->date)) == date('Ymd', strtotime('yesterday'))){
            return 'Вчера в '.date('H:i', strtotime($this->date));
        } else {
            if(date('Y') > date('Y', strtotime($this->date))){
                return $this->replaceMonth(date('d F Y в H:i', strtotime($this->date)));
            } else {
                return $this->replaceMonth(date('d F в H:i', strtotime($this->date)));
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
