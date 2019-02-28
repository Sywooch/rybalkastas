<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_certificates".
 *
 * @property integer $certificateID
 * @property string $certificateNumber
 * @property string $certificateCode
 * @property integer $certificateRating
 * @property integer $certificateUsed
 */
class SCCertificates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_certificates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['certificateNumber', 'certificateCode', 'certificateRating'], 'required'],
            [['certificateRating', 'certificateUsed'], 'integer'],
            [['certificateNumber'], 'string', 'max' => 13],
            [['certificateCode'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'certificateID' => 'Certificate ID',
            'certificateNumber' => 'Certificate Number',
            'certificateCode' => 'Certificate Code',
            'certificateRating' => 'Certificate Rating',
            'certificateUsed' => 'Certificate Used',
        ];
    }
}
