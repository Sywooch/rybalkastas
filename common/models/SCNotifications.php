<?php

namespace common\models;

use Faker\Provider\DateTime;
use Yii;

/**
 * This is the model class for table "SC_notifications".
 *
 * @property integer $id
 * @property integer $customerID
 * @property string $mini_text
 * @property string $full_text
 * @property integer $read
 * @property integer $shown
 * @property string $date
 */
class SCNotifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_notifications';
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
            [['customerID', 'mini_text', 'full_text'], 'required'],
            [['customerID', 'read', 'shown'], 'integer'],
            [['mini_text', 'full_text'], 'string'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customerID' => 'Customer ID',
            'mini_text' => 'Mini Text',
            'full_text' => 'Full Text',
            'read' => 'Read',
            'shown' => 'Shown',
            'date' => 'Date',
        ];
    }

    public function getTime()
    {
        return strtotime($this->date);
    }

    public function getHumanDate(){

        $time =  strtotime($this->date)-14400;

        $month_name =
            array( 1 => 'января',
                2 => 'февраля',
                3 => 'марта',
                4 => 'апреля',
                5 => 'мая',
                6 => 'июня',
                7 => 'июля',
                8 => 'августа',
                9 => 'сентября',
                10 => 'октября',
                11 => 'ноября',
                12 => 'декабря'
            );

        $month = $month_name[ date( 'n',$time ) ];

        $day   = date( 'j',$time );
        $year  = date( 'Y',$time );
        $hour  = date( 'G',$time );
        $min   = date( 'i',$time );

        $date = $day . ' ' . $month . ' ' . $year . ' г. в ' . $hour . ':' . $min;

        $dif = time() - $time;

        if($dif<59){
            return $dif." сек. назад";
        }elseif($dif/60>1 and $dif/60<59){
            return round($dif/60)." мин. назад";
        }elseif($dif/3600>1 and $dif/3600<23){
            return round($dif/3600)." час. назад";
        }else{
            return $date;
        }

    }
}
