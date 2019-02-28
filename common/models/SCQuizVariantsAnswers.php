<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_quiz_variants_answers".
 *
 * @property integer $variant_id
 * @property integer $user_id
 */
class SCQuizVariantsAnswers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_quiz_variants_answers';
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
            [['variant_id', 'user_id'], 'required'],
            [['variant_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'variant_id' => 'Variant ID',
            'user_id' => 'User ID',
        ];
    }
}
