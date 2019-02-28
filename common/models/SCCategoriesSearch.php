<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\models\SCCategories;

/**
 * SCCategoriesSearch represents the model behind the search form about `common\models\SCCategories`.
 */
class SCCategoriesSearch extends SCCategories
{
    public $search_s;
    public $filter;
    public $price;
    public $name;

    public $onlyActions;
    public $onlyAvailable;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoryID', 'parent', 'products_count', 'products_count_admin', 'sort_order', 'viewed_times', 'allow_products_comparison', 'allow_products_search', 'show_subcategories_products', 'vkontakte_type', 'menutype', 'show_tagsflow', 'show_monsflow', 'show_filter', 'main_sort', 'showprices', 'showsubmenu'], 'integer'],
            [['onlyActions', 'onlyAvailable'], 'boolean'],
            [['picture', 'name_en', 'description_en', 'meta_title_en', 'meta_description_en', 'meta_keywords_en', 'slug', 'name_ru', 'description_ru', 'meta_title_ru', 'meta_description_ru', 'meta_keywords_ru', 'id_1c', 'head_picture', 'tags', 'monufacturer', 'menupicture', 'hidden', 'add_parents', 'inbrandname', 'inbrandpicture', 'search_s', 'filter', 'price', 'name'], 'safe'],
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
     * @param $id
     * @param bool $onlyActions
     * @param null $forceParams
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public function search($id, $onlyActions = false, $forceParams = null, $method = null)
    {
        $sortables = [
            'name_ru' => 'name_ru'
        ];

        if (isset($_GET['onlyAvailable']) && $_GET['onlyAvailable'] == 1) {
            $this->onlyAvailable = 1;
        }

        if (isset($_GET['onlyActions']) && $_GET['onlyActions'] == 1) {
            $this->onlyActions = 1;
        }

        if ((isset(Yii::$app->request->queryParams) && !empty(Yii::$app->request->queryParams['SCCategoriesSearch'])) || !empty($forceParams)) {
            if (!empty($forceParams)) {
                $params = $forceParams;
            } else {
                $params = Yii::$app->request->queryParams['SCCategoriesSearch'];
            }

            if (!empty($params['filter']) || !empty($params['price']) || !empty($params['monufacturer']) || !empty($params['tags'])) {
                $sortables['name_ru'] = '`0`.name_ru';

                $group = null;

                switch($method){
                    case 'tags':
                        $group = 'categoryID';
                        break;
                }

                $query = SCCategories::findInnerProducts(intval($id), false, $group)
                    ->leftJoin('SC_categories', 'SC_categories.categoryID = `0`.categoryID');

                $options      = isset($params['filter']) ? $params['filter'] : [];
                $tags         = !empty($params['tags']) ? $params['tags'] : [];
                $monufacturer = !empty($params['monufacturer']) ? $params['monufacturer'] : [];

                //print_r($options); die;

                /*
                foreach ($options as $k=>$v) {
                    foreach ($v as $kv=>$fval) {
                        if ($fval == 0) {
                            unset($v[$kv]);
                        }

                        $options[$k]=$v;
                    }

                    if (empty($options[$k]))unset($options[$k]);
                }
                */

                foreach ($options as $k=>$opt) {
                    if (empty($opt)) continue;

                    $optionID = explode('_',$k)[1];

                    $i = 0;

                    foreach ($opt as $oval) {
                        $query->leftJoin('SC_product_options_values opt' . $optionID . '_' . $i, 'opt' . $optionID . '_' . $i . '.productID = `0`.productID');
                        //print_r($opt);die;

                        $orConds = $this->getConds($optionID,$opt, $i);

                        $query->andWhere($orConds);
                        $query->andWhere(['opt' . $optionID . '_' . $i . '.optionID' => $optionID]);

                        $i++;
                    }
                }

                $price = explode(',',$this->price);
                $monsConditions = [];
                $monsConditions[] = 'or';

                if (is_array($monufacturer)) {
                    foreach ($monufacturer as $mon){
                        $monsConditions[] = [
                            'or',
                            ['like', 'monufacturer', $mon]
                        ];
                    }
                } else {
                    $monsConditions[] = ['like', 'monufacturer', $monufacturer];
                }

                $tagsContitions = [];
                $tagsContitions[] = 'or';

                if (is_array($tags)) {
                    foreach ($tags as $tag){
                        $tagsContitions[] = [
                            'or',
                            ['like', 'tags', $tag]
                        ];
                    }
                } else {
                    $tagsContitions[] = ['like', 'tags', $tags];
                }

                if($_SERVER['REMOTE_ADDR'] == "176.107.242.44"){
                    //print_r($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
                }

                $in = Yii::$app->db->cache(function () use ($query, $id) {
                    return ArrayHelper::getColumn($query->all(), 'categoryID');
                }, 604800, new \yii\caching\TagDependency(['tags' => 'category_' . $id]));

                //$in = , 'categoryID');
                //print_r($in);
                //$query = SCCategories::find()->where(['in', 'categoryID', $in])->groupBy(['categoryID']);

                if (!empty($monsConditions)) {
                    $query->andFilterWhere($monsConditions);
                }

                if (!empty($tagsContitions)) {
                    $query->andFilterWhere($tagsContitions);
                }
            } else {
                $query = SCCategories::findWithParents($id);
            }
        } else {
            //"json_contains(`data_json`, '{\"$id\" : \"$value\"}')"
            //$query = SCCategories::findWithParents($id)->leftJoin('SC_category_meta', 'SC_category_meta.categoryID = SC_categories.categoryID')->orderBy("IF( countInStock > 0, CONCAT(1), CONCAT(0)) DESC");

            $query = SCCategories::findWithParents($id);

            if ($onlyActions) {
                $query = $query->andWhere('JSON_UNQUOTE(JSON_EXTRACT(meta_data, "$.countActionInStock")) > 0');

            }
        }
        // add conditions that should always apply here

        $sort = "sort_order ASC";

        switch (SCCategories::findOne($id)->sort_type){
            case 'default':
                $sort = 'sort_order ASC';
                break;
            case 'asc':
                $sort = $sortables['name_ru'].' ASC';
                break;
            case 'desc':
                $sort = $sortables['name_ru'].' DESC';
                break;
        }

        Yii::trace(Json::encode($sort), 'testing');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => !empty($params['filter']) ? 99999 : 9999,
            ],
            'sort' => [
                'defaultOrder' => ['sort_order' => SORT_ASC],
                'attributes' => [
                    'sort_order',
                    'name_ru',
                    'minPrice'=>[
                        'asc' => [($onlyActions ? 'JSON_EXTRACT(meta_data, JSON_UNQUOTE("$.minActionPrice"))' : 'JSON_EXTRACT(meta_data, JSON_UNQUOTE("$.minPrice"))') => SORT_ASC],
                        'desc' => ['JSON_EXTRACT(meta_data, JSON_UNQUOTE("$.maxPrice"))' => SORT_DESC],
                    ]
                ],
            ],
        ]);

        if (isset(Yii::$app->request->queryParams)){
            $this->load(Yii::$app->request->queryParams);
        }

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
              ->andFilterWhere(['like', 'name_ru', $this->search_s])
              ->orFilterWhere(['like', 'product_code', $this->search_s])
              ->andFilterWhere(['like', 'description_ru', $this->description_ru])
              ->andFilterWhere(['like', 'meta_title_ru', $this->meta_title_ru])
              ->andFilterWhere(['like', 'meta_description_ru', $this->meta_description_ru])
              ->andFilterWhere(['like', 'meta_keywords_ru', $this->meta_keywords_ru])
              ->andFilterWhere(['like', 'id_1c', $this->id_1c])
              ->andFilterWhere(['like', 'head_picture', $this->head_picture])
            //->andFilterWhere(['like', 'tags', $this->tags])
            //->andFilterWhere(['like', 'monufacturer', $this->monufacturer])
              ->andFilterWhere(['like', 'menupicture', $this->menupicture])
              ->andFilterWhere(['like', 'hidden', $this->hidden])
              ->andFilterWhere(['like', 'add_parents', $this->add_parents])
              ->andFilterWhere(['like', 'inbrandname', $this->inbrandname])
              ->andFilterWhere(['like', 'inbrandpicture', $this->inbrandpicture]);

        if (!empty($params['price'])) {
            $query->andFilterWhere(['between', 'JSON_UNQUOTE(JSON_EXTRACT( meta_data, "$.minPrice"))', intval(explode(',',$this->price)[0]),intval(explode(',',$this->price)[1])]);
        }

        if ($this->onlyActions == 1) {
            $query->andFilterWhere(['>=','JSON_UNQUOTE(JSON_EXTRACT( meta_data, "$.countActionInStock"))', 1]);
        }

        if ($this->onlyAvailable == 1) {
            $query->andFilterWhere(['>','JSON_UNQUOTE(JSON_EXTRACT( meta_data, "$.countInStock"))', 0]);
        }

        if (empty($_GET['sort'])) {
            $query->addOrderBy(['IF(JSON_UNQUOTE(JSON_EXTRACT(meta_data, "$.countInStock")) <= 0, 0, 1 ) DESC, IF(picture IS NULL OR picture = "", 0, 1 ) DESC, '.$sort=>'']);
        }

        //$query = $query->groupBy('SC_categories.categoryID');

        /*if ($_SERVER['REMOTE_ADDR'] == "176.107.242.44") {
            print_r($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);die;
        }*/

        //print_r($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);die;

        return $dataProvider;
    }

    public function getConds($id, $opts, $i)
    {
        $opttype = SCProductOptions::findOne($id)->filterType;
        $orConds = [];
        $orConds[] = 'or';

        if ($opttype == 'range') {
            foreach ($opts as $kv=>$val) {
                $value = explode('-',$val);
                $fval = null;
                $lval = null;

                if (strpos($value[0], '.')) $fval = floatval(trim($value[0]));
                else $fval = intval(trim($value[0]));

                if (strpos($value[1], '.')) $lval = floatval(trim($value[1]));
                else $lval = intval(trim($value[1]));

                $orConds[] = ['between', 'SUBSTRING( `opt'.$id.'_'.$i.'`.option_value_ru, INSTR(`opt'.$id.'_'.$i.'`.option_value_ru, "-") + 1)', $fval,$lval];
            }
        } elseif ($opttype == 'checkbox') {
            foreach ($opts as $kv=>$val){
                $value = explode('-',$val);

                $fval = null;
                $lval = null;

                if (strpos($value[0], '.')) $fval = floatval(trim($value[0]));
                else $fval = intval(trim($value[0]));

                if (strpos($value[1], '.')) $lval = floatval(trim($value[1]));
                else $lval = intval(trim($value[1]));

                $orConds[] = ['between', 'SUBSTRING( `opt'.$id.'_'.$i.'`.option_value_ru, INSTR(`opt'.$id.'_'.$i.'`.option_value_ru, "-") + 1)', $fval,$lval];
            }
        } elseif ($opttype == 'finder') {
            foreach ($opts as $kv=>$val){
                if(strpos($val, '-') !== false){
                    $value = explode('-',$val);
                    $fval = null;
                    $lval = null;
                    if(strpos($value[0], '.')) $fval = floatval(trim($value[0]));
                    else $fval = intval(trim($value[0]));

                    if(strpos($value[1], '.')) $lval = floatval(trim($value[1]));
                    else $lval = intval(trim($value[1]));


                    $orConds[] = ['between', 'SUBSTRING( `opt'.$id.'_'.$i.'`.option_value_ru, INSTR(`opt'.$id.'_'.$i.'`.option_value_ru, "-") + 1)', $fval,$lval];
                } else {
                    $orConds[] = '`opt'.$id.'_'.$i.'`.option_value_ru = "'.$val.'"';
                    $orConds[] = '`opt'.$id.'_'.$i.'`.option_value_ru LIKE "%'.$val.'%"';
                }
            }
        } else /** choose **/{
            foreach ($opts as $kv=>$val){
                $orConds[] = ['in', 'opt'.$id.'_'.$i.'.option_value_ru', $val];
            }
        }


        return $orConds;
    }

    public function attributeLabels()
    {
        $ar = [
            'onlyActions'=>'Только акции',
            'onlyAvailable'=>'Только в наличии',
        ];
        return array_merge(parent::attributeLabels(), $ar); // TODO: Change the autogenerated stub
    }
}
