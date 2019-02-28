<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SCCategories;

/**
 * SCCategoriesSearch represents the model behind the search form about `common\models\SCCategories`.
 */
class SCProductsSearch extends SCProducts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru', 'product_code', '1c_id'], 'safe'],
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
        $query = SCProducts::find();

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
            'categoryID' => $this->categoryID,
            'parent' => $this->parent,
            'products_count' => $this->products_count,
            'products_count_admin' => $this->products_count_admin,
            'sort_order' => $this->sort_order,
            'viewed_times' => $this->viewed_times,
            'allow_products_comparison' => $this->allow_products_comparison,
            'allow_products_search' => $this->allow_products_search,
            'show_subcategories_products' => $this->show_subcategories_products,
            'vkontakte_type' => $this->vkontakte_type,
            'menutype' => $this->menutype,
            'show_tagsflow' => $this->show_tagsflow,
            'show_monsflow' => $this->show_monsflow,
            'show_filter' => $this->show_filter,
            'main_sort' => $this->main_sort,
            'showprices' => $this->showprices,
            'showsubmenu' => $this->showsubmenu,
        ]);

        $query->andFilterWhere(['like', 'picture', $this->picture])
            ->andFilterWhere(['like', 'name_en', $this->name_en])
            ->andFilterWhere(['like', 'description_en', $this->description_en])
            ->andFilterWhere(['like', 'meta_title_en', $this->meta_title_en])
            ->andFilterWhere(['like', 'meta_description_en', $this->meta_description_en])
            ->andFilterWhere(['like', 'meta_keywords_en', $this->meta_keywords_en])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name_ru', $this->name_ru])
            ->andFilterWhere(['like', 'description_ru', $this->description_ru])
            ->andFilterWhere(['like', 'meta_title_ru', $this->meta_title_ru])
            ->andFilterWhere(['like', 'meta_description_ru', $this->meta_description_ru])
            ->andFilterWhere(['like', 'meta_keywords_ru', $this->meta_keywords_ru])
            ->andFilterWhere(['like', 'id_1c', $this->id_1c])
            ->andFilterWhere(['like', 'head_picture', $this->head_picture])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'monufacturer', $this->monufacturer])
            ->andFilterWhere(['like', 'menupicture', $this->menupicture])
            ->andFilterWhere(['like', 'hidden', $this->hidden])
            ->andFilterWhere(['like', 'add_parents', $this->add_parents])
            ->andFilterWhere(['like', 'inbrandname', $this->inbrandname])
            ->andFilterWhere(['like', 'inbrandpicture', $this->inbrandpicture]);

        return $dataProvider;
    }
}
