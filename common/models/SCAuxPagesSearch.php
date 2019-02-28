<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SCAuxPages;

/**
 * SCAuxPagesSearch represents the model behind the search form about `common\models\SCAuxPages`.
 */
class SCAuxPagesSearch extends SCAuxPages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aux_page_ID', 'aux_page_text_type', 'aux_page_enabled', 'aux_page_priority', 'aux_page_in_modal', 'parent', 'aux_page_in_footer'], 'integer'],
            [['aux_page_name_en', 'aux_page_text_en', 'aux_page_slug', 'meta_keywords_en', 'meta_description_en', 'aux_page_name_ru', 'aux_page_text_ru', 'meta_keywords_ru', 'meta_description_ru'], 'safe'],
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
        $query = SCAuxPages::find();

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
            'aux_page_ID' => $this->aux_page_ID,
            'aux_page_text_type' => $this->aux_page_text_type,
            'aux_page_enabled' => $this->aux_page_enabled,
            'aux_page_priority' => $this->aux_page_priority,
            'aux_page_in_modal' => $this->aux_page_in_modal,
            'parent' => $this->parent,
            'aux_page_in_footer' => $this->aux_page_in_footer,
        ]);

        $query->andFilterWhere(['like', 'aux_page_name_en', $this->aux_page_name_en])
            ->andFilterWhere(['like', 'aux_page_text_en', $this->aux_page_text_en])
            ->andFilterWhere(['like', 'aux_page_slug', $this->aux_page_slug])
            ->andFilterWhere(['like', 'meta_keywords_en', $this->meta_keywords_en])
            ->andFilterWhere(['like', 'meta_description_en', $this->meta_description_en])
            ->andFilterWhere(['like', 'aux_page_name_ru', $this->aux_page_name_ru])
            ->andFilterWhere(['like', 'aux_page_text_ru', $this->aux_page_text_ru])
            ->andFilterWhere(['like', 'meta_keywords_ru', $this->meta_keywords_ru])
            ->andFilterWhere(['like', 'meta_description_ru', $this->meta_description_ru]);

        return $dataProvider;
    }
}
