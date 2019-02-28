<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;

/**
 * SCCategoriesSearch represents the model behind the search form about `common\models\SCCategories`.
 */
class SCCategoriesSearchMicro extends SCCategories
{

    public $search_s;
    public $filter;
    public $price;
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoryID', 'parent', 'products_count', 'products_count_admin', 'sort_order', 'viewed_times', 'allow_products_comparison', 'allow_products_search', 'show_subcategories_products', 'vkontakte_type', 'menutype', 'show_tagsflow', 'show_monsflow', 'show_filter', 'main_sort', 'showprices', 'showsubmenu'], 'integer'],
            [['name_ru'], 'string'],
            [['picture', 'name_en', 'description_en', 'meta_title_en', 'meta_description_en', 'meta_keywords_en', 'slug', 'description_ru', 'meta_title_ru', 'meta_description_ru', 'meta_keywords_ru', 'id_1c', 'head_picture', 'tags', 'monufacturer', 'menupicture', 'hidden', 'add_parents', 'inbrandname', 'inbrandpicture', 'search_s', 'filter', 'price', 'name'], 'safe'],
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
     * @return SqlDataProvider
     */
    public function search()
    {
        $this->search_s =  str_replace('"', '\"', $this->search_s);
        $this->search_s = str_replace(' ', '%', $this->search_s);

        /*$totalCount = Yii::$app->db->createCommand('SELECT count(*) FROM (SELECT count(*) AS count FROM SC_categories WHERE name_ru LIKE "%' . $this->search_s . '%" AND categoryID <> 0
                                                  UNION SELECT count(*) AS count FROM SC_products WHERE name_ru LIKE "%' . $this->search_s . '%" OR product_code LIKE "%' . $this->search_s . '%") t2')->queryScalar();*/

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM(SELECT name_ru, name_ru AS name, SC_categories.categoryID as objectID, SC_categories.categoryID, CONCAT("category", "") as type, sort_order, CONCAT("category", "") as product_code FROM SC_categories WHERE name_ru LIKE "%' . $this->search_s . '%" AND SC_categories.categoryID <> 0
                UNION SELECT name_ru, name_ru AS name, SC_products.productID as objectID, SC_products.categoryID, CONCAT("product", "") as type, sort_order, product_code  FROM SC_products WHERE (name_ru LIKE "%' . $this->search_s . '%" OR product_code LIKE "%' . $this->search_s . '%" OR productID = "' . $this->search_s . '") AND categoryID <> 0) tbl GROUP BY categoryID',
            'params' => [':status' => 1],
            //'totalCount' => $totalCount,
            'sort' => [
                'attributes' => [
                    'age',
                    'name' => [
                        'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                        'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                ],
            ],
            'pagination' => [
                'pageSize' => 60,
            ],
        ]);

        //print_r($dataProvider->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

        if (isset(Yii::$app->request->queryParams)) {
            $this->load(Yii::$app->request->queryParams);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //print_r($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

        return $dataProvider;
    }
}
