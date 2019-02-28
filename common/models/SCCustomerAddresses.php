<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_customer_addresses".
 *
 * @property integer $addressID
 * @property integer $customerID
 * @property string $first_name
 * @property string $last_name
 * @property integer $countryID
 * @property integer $zoneID
 * @property string $zip
 * @property string $state
 * @property string $city
 * @property string $address
 * @property string $full_address
 * @property string $street
 * @property string $house
 */
class SCCustomerAddresses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_customer_addresses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customerID', 'countryID', 'zoneID'], 'integer'],
            [['address', 'full_address'], 'string'],
            [['first_name', 'last_name', 'zip', 'state', 'city'], 'string', 'max' => 64],
            [['street'], 'string', 'max' => 128],
            [['house'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'addressID' => 'Address ID',
            'customerID' => 'Customer ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'countryID' => 'Country ID',
            'zoneID' => 'Zone ID',
            'zip' => 'Zip',
            'state' => 'State',
            'city' => 'City',
            'address' => 'Address',
            'full_address' => 'Full Address',
            'street' => 'Street',
            'house' => 'House',
        ];
    }
}
