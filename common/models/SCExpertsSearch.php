<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SCExperts;

/**
 * SCExpertsSearch represents the model behind the search form about `common\models\SCExperts`.
 */
class SCExpertsSearch extends SCExperts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expert_id', 'is_online', 'shop_id', 'sort_order', 'user_id'], 'integer'],
            [['expert_name', 'expert_last_name', 'mini_description', 'full_text', 'picture', 'title', 'blog_picture', 'shop', 'expert_fullname', '1c_id', 'email'], 'safe'],
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
        $query = SCExperts::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'expert_id' => $this->expert_id,
            'is_online' => $this->is_online,
            'shop_id' => $this->shop_id,
            'sort_order' => $this->sort_order,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'expert_name', $this->expert_name])
            ->andFilterWhere(['like', 'expert_last_name', $this->expert_last_name])
            ->andFilterWhere(['like', 'mini_description', $this->mini_description])
            ->andFilterWhere(['like', 'full_text', $this->full_text])
            ->andFilterWhere(['like', 'picture', $this->picture])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'blog_picture', $this->blog_picture])
            ->andFilterWhere(['like', 'shop', $this->shop])
            ->andFilterWhere(['like', 'expert_fullname', $this->expert_fullname])
            ->andFilterWhere(['like', '1c_id', $this->{'1c_id'}])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
