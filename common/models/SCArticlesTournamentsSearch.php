<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SCArticlesTournaments;

/**
 * SCArticlesTournamentsSearch represents the model behind the search form about `common\models\SCArticlesTournaments`.
 * @property int $sort_order [int(11)]
 */
class SCArticlesTournamentsSearch extends SCArticlesTournaments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NID', 'add_stamp', 'priority', 'brand', 'published'], 'integer'],
            [['add_date', 'title_en', 'title_ru', 'picture', 'textToPublication_en', 'textToPublication_ru', 'textToMail', 'emailed', 'textMini', 'textPreview', 'tpl', 'created_at', 'updated_at', 'published_at'], 'safe'],
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
        $query = SCArticlesTournaments::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sort_order' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'NID' => $this->NID,
            'add_stamp' => $this->add_stamp,
            'priority' => $this->priority,
            'brand' => $this->brand,
            'published' => $this->published,
        ]);

        $query->andFilterWhere(['like', 'add_date', $this->add_date])
              ->andFilterWhere(['like', 'title_en', $this->title_en])
              ->andFilterWhere(['like', 'title_ru', $this->title_ru])
              ->andFilterWhere(['like', 'picture', $this->picture])
              ->andFilterWhere(['like', 'textToPublication_en', $this->textToPublication_en])
              ->andFilterWhere(['like', 'textToPublication_ru', $this->textToPublication_ru])
              ->andFilterWhere(['like', 'textToMail', $this->textToMail])
              ->andFilterWhere(['like', 'emailed', $this->emailed])
              ->andFilterWhere(['like', 'textMini', $this->textMini])
              ->andFilterWhere(['like', 'textPreview', $this->textPreview])
              ->andFilterWhere(['like', 'tpl', $this->tpl])
              ->andFilterWhere(['like', 'created_at', $this->created_at])
              ->andFilterWhere(['like', 'updated_at', $this->updated_at])
              ->andFilterWhere(['like', 'published_at', $this->published_at]);

        return $dataProvider;
    }
}
