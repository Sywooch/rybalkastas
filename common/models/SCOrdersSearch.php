<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SCOrders;

/**
 * SCOrdersSearch represents the model behind the search form about `common\models\SCOrders`.
 */
class SCOrdersSearch extends SCOrders
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderID', 'customerID', 'shipping_module_id', 'payment_module_id', 'statusID', 'affiliateID', 'manager_id'], 'integer'],
            [['order_time', 'customer_ip', 'shipping_type', 'payment_type', 'customers_comment', 'discount_description', 'currency_code', 'customer_firstname', 'customer_lastname', 'customer_email', 'shipping_firstname', 'shipping_lastname', 'shipping_country', 'shipping_state', 'shipping_zip', 'shipping_city', 'shipping_address', 'billing_firstname', 'billing_lastname', 'billing_country', 'billing_state', 'billing_zip', 'billing_city', 'billing_address', 'cc_number', 'cc_holdername', 'cc_expires', 'cc_cvv', 'shippingServiceInfo', 'google_order_number', 'source', 'id_1c', 'user_phone'], 'safe'],
            [['shipping_cost', 'order_discount', 'order_amount', 'currency_value'], 'number'],
            [['containsItem'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SCOrders::find()->orderBy("orderID DESC");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere([
            'orderID' => $this->orderID,
            'customerID' => $this->customerID,
            'order_time' => $this->order_time,
            'shipping_module_id' => $this->shipping_module_id,
            'payment_module_id' => $this->payment_module_id,
            'statusID' => $this->statusID,
            'shipping_cost' => $this->shipping_cost,
            'order_discount' => $this->order_discount,
            'order_amount' => $this->order_amount,
            'currency_value' => $this->currency_value,
            'affiliateID' => $this->affiliateID,
            'manager_id' => $this->manager_id,
        ]);

        $query->andFilterWhere(['like', 'customer_ip', $this->customer_ip])
            ->andFilterWhere(['like', 'shipping_type', $this->shipping_type])
            ->andFilterWhere(['like', 'payment_type', $this->payment_type])
            ->andFilterWhere(['like', 'customers_comment', $this->customers_comment])
            ->andFilterWhere(['like', 'discount_description', $this->discount_description])
            ->andFilterWhere(['like', 'currency_code', $this->currency_code])
            ->andFilterWhere(['like', 'customer_firstname', $this->customer_firstname])
            ->andFilterWhere(['like', 'customer_lastname', $this->customer_lastname])
            ->andFilterWhere(['like', 'customer_email', $this->customer_email])
            ->andFilterWhere(['like', 'shipping_firstname', $this->shipping_firstname])
            ->andFilterWhere(['like', 'shipping_lastname', $this->shipping_lastname])
            ->andFilterWhere(['like', 'shipping_country', $this->shipping_country])
            ->andFilterWhere(['like', 'shipping_state', $this->shipping_state])
            ->andFilterWhere(['like', 'shipping_zip', $this->shipping_zip])
            ->andFilterWhere(['like', 'shipping_city', $this->shipping_city])
            ->andFilterWhere(['like', 'shipping_address', $this->shipping_address])
            ->andFilterWhere(['like', 'billing_firstname', $this->billing_firstname])
            ->andFilterWhere(['like', 'billing_lastname', $this->billing_lastname])
            ->andFilterWhere(['like', 'billing_country', $this->billing_country])
            ->andFilterWhere(['like', 'billing_state', $this->billing_state])
            ->andFilterWhere(['like', 'billing_zip', $this->billing_zip])
            ->andFilterWhere(['like', 'billing_city', $this->billing_city])
            ->andFilterWhere(['like', 'billing_address', $this->billing_address])
            ->andFilterWhere(['like', 'cc_number', $this->cc_number])
            ->andFilterWhere(['like', 'cc_holdername', $this->cc_holdername])
            ->andFilterWhere(['like', 'cc_expires', $this->cc_expires])
            ->andFilterWhere(['like', 'cc_cvv', $this->cc_cvv])
            ->andFilterWhere(['like', 'shippingServiceInfo', $this->shippingServiceInfo])
            ->andFilterWhere(['like', 'google_order_number', $this->google_order_number])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'id_1c', $this->id_1c])
            ->andFilterWhere(['like', 'user_phone', $this->user_phone]);

        if(!empty($this->containsItem)){
            $query->joinWith(['products' => function ($q) {
                $q->where('`SC_ordered_carts`.name LIKE "%' . trim($this->containsItem) . '%"');
            }]);
        }

        return $dataProvider;
    }
}
