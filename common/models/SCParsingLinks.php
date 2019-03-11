<?php
/**
 * Created by PhpStorm.
 * User: Lakkinzi
 * Date: 2/5/2019
 * Time: 15:48
 */

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

use yii\db\ActiveRecord;
use common\models\SCParsing;
use common\models\SCProducts;
use Yii;
class SCParsingLinks extends ActiveRecord
{

    /**
     * This is the model class for table "SCParsingLinks".
     *
     * @property int $id
     * @property string $links
     * @property string $created_at
     * @property string $updated_at

     */

    public static function tableName()
    {
        return 'sc_parsing_links';
    }

    public static function getDb()
    {
        return Yii::$app->get('db');
    }
    public function rules()
    {
        return
            [

                [['links'], 'unique'],
//                [['created_at', 'updated_at'], 'safe'],
            ];
    }
    public function attributes()
    {
        return [
            'id',
            'links',
            'created_at',
            'updated_at',
        ];
    }

    public static function primaryKey()
    {
        return "links";
    }
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'links' => 'links',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // если вместо метки времени UNIX используется datetime:
              'value' => function(){ return time();},
            ],
        ];
    }
}