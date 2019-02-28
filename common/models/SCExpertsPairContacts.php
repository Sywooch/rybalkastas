<?php
/**
 * Created by PhpStorm.
 * User: dimoss
 * Date: 12.09.18
 * Time: 10:09
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class SCExpertsPairContacts
 *
 * @package models\
 * @property int $id [int(11)]
 * @property int $shop_id [int(11)]
 * @property string $email [varchar(255)]
 * @property int $pair [int(11)]
 * @property string $mailer_id
 *
 */
class SCExpertsPairContacts extends ActiveRecord
{
    /**
     * @return array|string
     */
    public static function tableName()
    {
        return 'SC_experts_pair_contacts';
    }

    /**
     * @return \yii\db\Connection|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }
}
