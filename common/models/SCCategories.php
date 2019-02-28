<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;
use yii\db\Query;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii2mod\settings\models\SettingModel;
use common\behaviors\UnifyBehavior;
use common\models\mongo\CategoryInfo;

/**
 * This is the model class for table "SC_categories".
 *
 * @property integer $categoryID
 * @property integer $parent
 * @property integer $products_count
 * @property string $picture
 * @property integer $products_count_admin
 * @property integer $sort_order
 * @property integer $viewed_times
 * @property integer $allow_products_comparison
 * @property integer $allow_products_search
 * @property integer $show_subcategories_products
 * @property string $name_en
 * @property string $description_en
 * @property string $meta_title_en
 * @property string $meta_description_en
 * @property string $meta_keywords_en
 * @property string $slug
 * @property string $name_ru
 * @property string $description_ru
 * @property string $meta_title_ru
 * @property string $meta_description_ru
 * @property string $meta_keywords_ru
 * @property integer $vkontakte_type
 * @property integer $menutype
 * @property string $id_1c
 * @property string $head_picture
 * @property string $tags
 * @property string $monufacturer
 * @property string $menupicture
 * @property string $hidden
 * @property string $add_parents
 * @property integer $show_tagsflow
 * @property integer $show_monsflow
 * @property integer $show_catsflow
 * @property integer $show_filter
 * @property integer $main_sort
 * @property integer $showprices
 * @property integer $showsubmenu
 * @property string $inbrandname
 * @property string $inbrandpicture
 * @property string $meta_data
 * @property string $sort_type
 * @property string $name_extended
 * @property string $na_message
 * @property string $cat_path
 * @property string $subheader
 * @property $isProduct
 * @property $hasProducts
 * @property $meta
 * @property $isNew
 */
class SCCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $hasChilds;
    public $parents;
    public $root;

    public static function tableName()
    {
        return 'SC_categories';
    }

    /**
     * @return object
     * @throws \yii\base\InvalidConfigException
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
            [['parent', 'products_count', 'products_count_admin', 'sort_order', 'viewed_times', 'allow_products_comparison', 'allow_products_search', 'show_subcategories_products', 'vkontakte_type', 'menutype', 'show_tagsflow', 'show_monsflow', 'show_catsflow', 'show_filter', 'main_sort', 'showprices', 'showsubmenu', 'hasChilds'], 'integer'],
            [['description_en', 'description_ru', 'monufacturer', 'meta_data', 'sort_type', 'subheader'], 'string'],
            [['head_picture'], 'safe'],
            [['picture'], 'safe'],
            [['head_picture'], 'file', 'extensions' => 'jpg, gif, png'],
            [['picture'], 'file', 'extensions' => 'jpg, gif, png'],
            [['name_en', 'meta_title_en', 'meta_description_en', 'meta_keywords_en', 'slug', 'name_ru', 'meta_title_ru', 'meta_description_ru', 'meta_keywords_ru', 'add_parents', 'inbrandname', 'inbrandpicture', 'name_extended'], 'string', 'max' => 255],
            [['id_1c'], 'string', 'max' => 36],
            [['tags'], 'string', 'max' => 500],
            [['na_message'], 'string', 'max' => 10255],
            [['menupicture'], 'string', 'max' => 110],
            [['hidden'], 'string', 'max' => 5],
            [['sort_type'], 'safe'],
            [['cat_path'], 'string']
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'unify' => [
                'class'=>UnifyBehavior::className(),
                'name'=>'name_ru',
                'type'=>'Категория товаров',
                //'name'=>'name_ru',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryID' => 'ID Категории',
            'parent' => 'Родительская категория',
            'products_count' => 'Количество товаров',
            'picture' => 'Картинка',
            'products_count_admin' => 'Количество товаров админки',
            'sort_order' => 'Порядок сортировки',
            'viewed_times' => 'Количество просмотров',
            'allow_products_comparison' => 'Разрешить сравнение',
            'allow_products_search' => 'Разрешить поиск',
            'show_subcategories_products' => 'Показывать товары подкатегорий',
            'name_en' => 'Name En',
            'description_en' => 'Description En',
            'meta_title_en' => 'Meta Title En',
            'meta_description_en' => 'Meta Description En',
            'meta_keywords_en' => 'Meta Keywords En',
            'slug' => 'Алиас',
            'name_ru' => 'Название',
            'description_ru' => 'Описание',
            'meta_title_ru' => 'Meta Title',
            'meta_description_ru' => 'Meta Description',
            'meta_keywords_ru' => 'Meta Keywords',
            'vkontakte_type' => 'Vkontakte Type',
            'menutype' => 'Вид категории',
            'id_1c' => 'ID 1C',
            'head_picture' => 'Шапка',
            'tags' => 'Тэги',
            'tagar' => 'Тэги',
            'monufacturer' => 'Производитель',
            'menupicture' => 'Картинка меню',
            'hidden' => 'Скрыта',
            'add_parents' => 'Add Parents',
            'show_tagsflow' => 'Показывать теги',
            'show_monsflow' => 'Показывать производителей',
            'show_catsflow' => 'Показывать категории',
            'show_filter' => 'Показывать фильтр',
            'main_sort' => 'Сортировка на главной',
            'showprices' => 'Показывать цены',
            'showsubmenu' => 'Показывать подменю',
            'inbrandname' => 'Название в бренде',
            'inbrandpicture' => 'Картинка в бренде',
            'parents' => 'Родительские категории',
            'sort_type' => 'Тип сортировки',
            'name_extended' => 'Расширенное название',
            'na_message' => 'Замена сообщению "Нет в наличии"',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!empty($_POST['SCCategories']['tagar'])) {
            $this->tags = trim(implode(',', $_POST['SCCategories']['tagar']));
        } else {
            //$this->tags = null;
        }

        // otherwise you may save it as previous examples
        // before assigning its returned id to $this->logo_id
        // it will be good to have also plans for unexpected errors

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $key = "category_has_childs_" . $this->categoryID;
        $cache = Yii::$app->cache;

        if (empty($this->meta_data)) {
            //echo $this->categoryID.',';
            //$this->generateMeta();
        }

        $ct = $cache->getOrSet($key, function () {
            $ct = SCCategories::find()->where('parent = ' . $this->categoryID)->count();

            $sub = SCParentalConnections::find()->where("parent = " . $this->categoryID)->all();
            $ar = array();
            foreach ($sub as $s) {
                $ar[] = $s->categoryID;
            }

            $children = SCCategories::find()->where(['in', 'categoryID', $ar])->count();

            $ct = $ct + $children;

            return $ct;
        }, 86400, new TagDependency(['tags' => 'category_' . $this->categoryID]));

        if ($ct >= 1) {
            $this->hasChilds = 1;
        } else {
            $this->hasChilds = 0;
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws \yii\base\InvalidConfigException
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (!$insert) { // TODO: В некоторых категориях (например Воблеры) не хватает оперативной памяти для отработки методов!!!
            $this->resetMeta();
            $this->resetCache();

            //TagDependency::invalidate(Yii::$app->pageCache, 'category_' . $this->categoryID);
        } else {
            $path = array();

            $id = $this->categoryID;
            $parent = $this->parent;

            $path[] = $id;

            while ($parent <> 1) {
                $model = SCCategories::find()->where(['categoryID' => $parent])->one();

                if (empty($model)) break;

                $parent = $model->parent;

                $id = $model->categoryID;

                $path[] = $id;
            }

            $this->cat_path = Json::encode(array_reverse($path));

            $this->save();
        }

        $this->buildLinkage();

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * @param $id
     * @return \yii\db\ActiveQuery
     */
    public static function findWithInner($id)
    {
        $subcategory_ids = SCCategories::catGetSubCategoriesIds($id);
        $subcategory_ids[] = $id;

        $query = SCCategories::find()->where(['in', 'parent', $subcategory_ids]);
        $query2 = SCParentalConnections::find()->select('categoryID')->where(['in', 'parent', $subcategory_ids]);
        $query3 = SCCategories::find()->where(['in', 'categoryID', $query2]);
        $query->union($query3);

        return $query;
    }

    /**
     * @param $id
     * @return \yii\db\ActiveQuery
     */
    public static function findWithParents($id)
    {
        $query = SCCategories::find()->select(['*', 'name_ru as name'])->where(['parent' => $id]);
        $query2 = SCParentalConnections::find()->select('categoryID')->where(['parent' => $id]);
        $query3 = SCCategories::find()->select(['*', 'name_ru as name'])->where(['in', 'categoryID', $query2]);
        $query->union($query3);

        $sec = SCCategories::find()->from(['SC_categories' => $query]);

        return $sec;
    }

    /**
     * @param $id
     * @return \yii\db\ActiveQuery
     */
    public static function findWithParentsById($id)
    {
        $query = SCCategories::find()->select('categoryID')->where(['parent' => $id]);
        $query2 = SCParentalConnections::find()->select('categoryID')->where(['parent' => $id]);
        $query3 = SCCategories::find()->select('categoryID')->where(['in', 'categoryID', $query2]);
        $query->union($query3);

        return $query;
    }

    /**
     * @param $id
     * @return \yii\db\ActiveQuery
     */
    public static function findWithParentsInnerById($id)
    {
        $subcategory_ids = SCCategories::catGetSubCategoriesIds($id);
        $subcategory_ids[] = $id;

        $query = SCCategories::find()->select('categoryID')->where(['parent' => $id]);
        $query2 = SCParentalConnections::find()->select('categoryID')->where(['parent' => $id]);
        $query3 = SCCategories::find()->select('categoryID')->where(['in', 'categoryID', $query2]);
        $query->union($query3);

        return $query;
    }

    /**
     * @param $id
     * @param bool $instock
     * @return mixed
     */
    public static function findInnerProducts($id, $instock = false, $group = null)
    {
        $cache = Yii::$app->dbCache;

        $data = $cache->getOrSet('inner1_'.$id.'_instock1_'.(int)$instock.$group, function () use($instock, $id,$group) {
            $subcategory_ids = SCCategories::catGetSubCategoriesIds($id);

            $subcategory_ids[] = $id;

            $selection = [
                'SC_products.productID',
                'SC_products.categoryID',
                'SC_products.productID as objectID',
                'Price', 'Price as minPrice',
                'SC_products.name_ru',
                'SC_products.name_ru as name',
                "CONCAT(\"product\", \"\") as type",
            ];

            if ($instock) {
                $stockq = 'in_stock > 0';
            } else {
                $stockq = 'in_stock >= 0';
            }

            $query1 = SCProducts::find()->select($selection)->where(['in', 'SC_products.categoryID', $subcategory_ids])->andWhere($stockq);
            $query2 = SCParentalConnections::find()->select('categoryID')->where(['parent' => $id]);
            $query3 = SCProducts::find()->select($selection)->where(['in', 'SC_products.categoryID', $query2])->andWhere($stockq);

            if(!empty($group)){
                $query1 = $query1->groupBy($group);
                $query3 = $query3->groupBy($group);
            }



            $query1->union($query3);

            return (new Query())->select('*')->from([$query1]);

        }, 21600);

        return $data;
    }

    /**
     * @param $id
     * @return Query
     */
    public static function findWithInnerWithProducts($id)
    {
        $subcategory_ids = SCCategories::catGetSubCategoriesIds($id);
        $subcategory_ids[] = $id;

        $query1 = SCCategories::find()->select(["name_ru", "name_ru as name", "SC_categories.categoryID as objectID", "SC_categories.categoryID", "CONCAT(\"category\", \"\") as type", 'sort_order', "CONCAT(\"category\", \"\") as product_code"])->where(['in', 'parent', $subcategory_ids]);
        $query2 = SCParentalConnections::find()->select('categoryID')->where(['parent' => $id]);
        $query3 = SCCategories::find()->select(["name_ru", "name_ru as name", "SC_categories.categoryID as objectID", "SC_categories.categoryID", "CONCAT(\"category\", \"\") as type", 'sort_order', "CONCAT(\"category\", \"\") as product_code"])->where(['in', 'categoryID', $query2]);


        $query4 = SCProducts::find()->select(["name_ru", "name_ru as name", "SC_products.productID as objectID", "SC_products.categoryID", "CONCAT(\"product\", \"\") as type", 'sort_order', 'product_code'])->where(['in', 'categoryID', $subcategory_ids]);
        $query5 = SCProducts::find()->select(["name_ru", "name_ru as name", "SC_products.productID as objectID", "SC_products.categoryID", "CONCAT(\"product\", \"\") as type", 'sort_order', 'product_code'])->where(['in', 'categoryID', $query2]);

        $query1->union($query3);
        $query1->union($query4);
        $query1->union($query5);

        $query = (new Query())
            ->select('*')
            ->from([$query1])
            ->orderBy('type');

        return $query;
    }

    /**
     * @param $id
     * @return int
     */
    public function parentExists($id)
    {
        $con = SCParentalConnections::find()->where(['parent' => $this->categoryID, 'categoryID' => $id])->one();

        if (empty($con)) {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * @param $id
     * @return int
     */
    public function childExists($id)
    {
        $con = SCParentalConnections::find()->where(['categoryID' => $this->categoryID, 'parent' => $id])->one();

        if (empty($con)) {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * @param $id
     * @return int
     */
    public function relatedExists($id)
    {
        $con = SCRelatedCategories::find()
            ->where(['categoryID' => $id, 'relatedCategoryID' => $this->categoryID])
              ->one();

        if (empty($con)) {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * @param $id
     * @return int
     */
    public function selfRelatedExists($id)
    {
        $con = SCRelatedCategories::find()
            ->where([
                'categoryID'        => $this->categoryID,
                'relatedCategoryID' => $id
            ])
            ->one();

        return (int)!empty($con);
    }

    /**
     * @param $id
     * @return int
     */
    public function sameExists($id)
    {
        $con = SCSameCategories::find()
            ->where(['categoryID' => $id, 'subcategoryID' => $this->categoryID])
              ->one();

        $sub = SCParentalConnections::find()
            ->where(['parent' => $id, 'categoryID' => $this->categoryID])
              ->all();

        $ar = array();

        foreach ($sub as $s) {
            $ar[] = $s->categoryID;
        }

        $children = SCCategories::find()->where(['in', 'categoryID', $ar])->all();

        if (empty($con) && empty($children)) {
            return 0;
        } elseif (!empty($con) || !empty($children)) {
            return 1;
        }

        return 0;
    }

    /**
     * @return bool
     */
    public function getHasCategories()
    {
        $m = SCCategories::find()->where(['parent' => $this->categoryID])->one();

        if (!empty($m)) return true;

        return false;
    }

    /**
     * @return array
     */
    public function getChilds()
    {
        $con = SCParentalConnections::find()->where("parent = $this->categoryID")->all();

        $ids = array();

        foreach ($con as $c) {
            $ids[] = $c->categoryID;
        }

        $model = SCCategories::find()->where(['in', 'categoryID', $ids])->all();

        return $model;
    }

    /**
     * @return array
     */
    public function getParentss()
    {
        $con = SCParentalConnections::find()->where("categoryID = $this->categoryID")->all();

        $ids = array();

        foreach ($con as $c) {
            $ids[] = $c->parent;
        }

        $model = SCCategories::find()->where(['in', 'categoryID', $ids])->all();

        return $model;
    }

    /**
     * @return array
     */
    public function getRelated()
    {
        $con = SCRelatedCategories::find()->where("categoryID = $this->categoryID")->all();

        $ids = array();

        foreach ($con as $c) {
            $ids[] = $c->relatedCategoryID;
        }

        $model = SCCategories::find()->where(['in', 'categoryID', $ids])->all();

        return $model;
    }

    /**
     * @return array
     */
    public function getSelfRelated()
    {
        $con = SCRelatedCategories::find()
            ->where(['relatedCategoryID' => $this->categoryID])
              ->all();

        $ids = array();

        foreach ($con as $c) {
            $ids[] = $c->categoryID;
        }

        $model = SCCategories::find()
            ->where(['in', 'categoryID', $ids])
              ->all();

        return $model;
    }

    /**
     * @return array
     */
    public function getSame()
    {
        $con = SCSameCategories::find()->where("categoryID = $this->categoryID")->all();

        $ids = array();

        foreach ($con as $c) {
            $ids[] = $c->subcategoryID;
        }

        $model = SCCategories::find()->where(['in', 'categoryID', $ids])->all();

        return $model;
    }

    /**
     * @return array
     */
    public function getTagar()
    {
        $ar = explode(',', $this->tags);

        return $ar;
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        $categories = SCCategories::catGetSubCategories($this->categoryID);

        $ar = array();

        $ar[] = $this->categoryID;

        foreach ($categories as $c) {
            $ar[] = $c->categoryID;
        }

        $model = SCProducts::find()->select(['productID'])->where(['in', 'categoryID', $ar])->all();

        return $model;
    }

    /**
     * @return bool
     */
    public function getHasProducts()
    {
        $model = SCProducts::find()->where("categoryID = $this->categoryID")->count();

        if ($model > 0) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getParentObject()
    {
        return SCCategories::find()->where("categoryID = $this->parent")->one();
    }

    /**
     * @return array
     */
    public function getPath()
    {
        $path = array();

        $id = $this->categoryID;

        $parent = $this->parent;

        $path[] = ['id' => $id, 'name' => $this->name_ru];

        while ($parent <> 1) {
            $model = SCCategories::find()->where(['categoryID' => $parent])->one();

            if (empty($model)) break;

            $parent = $model->parent;

            $id = $model->categoryID;

            $path[] = ['id' => $id, 'name' => $model->name_ru];
        }

        return array_reverse($path);
    }

    /*
    public function getMeta()
    {
        $meta = SCCategoryMeta::findOne($this->categoryID);

        if(empty($meta)){
            $meta = new SCCategoryMeta();
            $subcategory_ids = SCCategories::catGetSubCategoriesIds($this->categoryID);
            $subcategory_ids[] = $this->categoryID;

            $meta->categoryID = $this->categoryID;
            $meta->countChildren = SCCategories::find()->where(['parent'=>$this->categoryID])->count();
            $meta->countAllChildren = SCCategories::find()->where(['in', 'parent', $subcategory_ids])->count();
            $meta->countProducts = SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->count();
            $meta->countInStock = SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->andWhere('in_stock > 0')->count();
            $meta->countActionInStock = SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->andWhere('list_price > Price')->andWhere('in_stock > 0')->count();
            $meta->minPrice = SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->andWhere('Price > 0')->min('Price');
            $meta->maxPrice = SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->max('Price');

            $getActions = SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->andWhere('list_price > Price')->count('productID');

            $meta->hasAction = 0;

            if($getActions > 0){
                $meta->hasAction = 1;
            }

            $meta->save();

            $meta = SCCategoryMeta::findOne($this->categoryID);
        }

        return $meta;
    }
    */

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getMeta()
    {
        if (empty($this->meta_data)) {
            $this->generateMeta();
        }

        if(empty($this->meta_data['hasAction'])){
            $meta = Json::decode($this->meta_data);
            $meta['hasAction'] = 0;
            $this->meta_data = Json::encode($meta);
        }

        return json_decode($this->meta_data);
    }

    /**
     * @return bool
     */
    public function getInTrash()
    {
        $check = Trash::find()->where(['item_id' => $this->getPrimaryKey(), 'class' => get_class($this)])->one();

        if (!empty($check)) return true;

        return false;
    }

    /**
     * @return bool
     */
    public function getIsProduct()
    {
        if ($this->menutype <> 0) return true;

        return false;
    }

    /**
     * @return array
     */
    public function getFullPath()
    {
        $path = json_decode($this->path);

        $models = SCCategories::find()->where(['in', 'categoryID', $path])->all();

        return $models;
    }

    /**
     * @return string
     */
    public function getPathString()
    {
        $models = $this->fullPath;

        $ar = [];

        foreach ($models as $m) {
            $ar[] = $m->name_ru;
        }

        return implode(' / ', $ar);
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function getTagsInside()
    {
        $model = $this;

        $subcats = \common\models\SCCategories::getDb()->cache(function ($db)  use ($model){
            return \common\models\SCCategories::findWithInner($model->categoryID, false)->all();
        });

        $tags = [];

        foreach ($subcats as $m) {
            if(!empty($_GET['monufacturer'])){
                $key = str_replace(' ', '_', $m->monufacturer);
                if($_GET['monufacturer'] <> $key){
                    //echo $_GET['monufacturer']. '<>' . $key.'<br/>';
                    continue;
                }
            }

            if(strpos($m->tags, ',') !== false){
                $tags_in = explode(',', $m->tags);
            } else {
                $tags_in[] = $m->tags;
            }
            foreach ($tags_in as $t) {
                $tags[] = trim($t);
            }
        }

        $tags = array_unique($tags);

        $tags_serialized = [];

        foreach ($tags as $tag){
            if (empty(trim($tag))) continue;

            $key = Inflector::slug($tag);

            /*
            $key = str_replace(' ', '_', $key);
            $key = str_replace('/', '-', $key);
            */;

            $tags_serialized[strtolower($key)] = trim(mb_strtolower($tag));
        }

        return $tags_serialized;
    }

    /**
     * @return mixed
     */
    public function getMonsInside()
    {
        $model = $this;

        $cache = Yii::$app->cache;

        if(empty($_GET['tag'])){
            $key = 'mons_inside_'.$model->categoryID;
        } else {
            $key = 'mons_inside_'.$model->categoryID.'_'.$_GET['tag'];
        }

        $monufacturers_serialized = $cache->getOrSet($key, function () use($model) {
            $subcats = \common\models\SCCategories::getDb()->cache(function ($db)  use ($model){
                return \common\models\SCCategories::findWithInner($model->categoryID, false)->all();
            });

            $monufacturers = [];

            foreach ($subcats as $m) {
                if(!empty($_GET['tag'])){
                    $key = Inflector::transliterate($m->tags);
                    $key = str_replace(' ', '_', $key);
                    $key = str_replace('/', '-', $key);

                    if (strpos($key, $_GET['tag']) == false) {
                        continue;
                    }

                }

                $monufacturers[] = $m->monufacturer;
            }

            $monufacturers = array_unique($monufacturers);

            $monufacturers_serialized = [];

            foreach ($monufacturers as $m) {
                if(empty(trim($m)))continue;

                //$key = Inflector::transliterate($tag);

                $key = str_replace(' ', '_', $m);

                //$key = str_replace('/', '-', $key);

                $monufacturers_serialized[$key] = $m;
            }

            asort($monufacturers_serialized);

            return $monufacturers_serialized;
        }, 86400, new TagDependency(['tags' => 'category_' . $this->categoryID]));

        return $monufacturers_serialized;
    }


    /**
     * @return bool
     */
    public function getIsNew(){

        $cache = Yii::$app->cache;

        $key = 'last_id';

        $keyCount = 'count_inside_'.$this->categoryID;

        $check = $cache->getOrSet($keyCount, function () {
            return SCProducts::find()->where(['categoryID'=>$this->categoryID])->count();
        });

        if(empty($check)) return false;

        $last = $cache->getOrSet($key, function () {
            $cat = SCCategories::find()->orderBy('categoryID DESC')->one();
            return intval($cat->categoryID);
        });

        //$last = SCCategories::find()->orderBy('categoryID DESC')->one()->categoryID;

        $first = $last - 5000;

        if($this->categoryID > $first){
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public static function getViewVariations()
    {
        return [
            \Yii::$app->user->can('alphaTester'),
            \Yii::$app->user->can('Employee'),
            \Yii::$app->request->isAjax,
            \Yii::$app->request->isPjax,
            !empty($_GET['id'])?$_GET['id']:null,
            !empty($_GET['monufacturer'])?$_GET['monufacturer']:null,
            !empty($_GET['tag'])?$_GET['tag']:null,
            !empty($_GET['SCCategoriesSearch'])?$_GET['SCCategoriesSearch']:null,
            !empty($_GET['SCCategoriesSearchMicro'])?$_GET['SCCategoriesSearchMicro']:null,
            !empty($_GET['product'])?$_GET['product']:null,
            !empty($_GET['sort'])?$_GET['sort']:null,
            !empty($_GET['onlyAvailable'])?$_GET['onlyAvailable']:null,
            !empty($_GET['onlyActions'])?$_GET['onlyActions']:null
        ];
    }

    /**
     * @return array
     */
    public function getLinkage()
    {
        return CategoryInfo::find()->where(['category_id'=>$this->categoryID])->one();
    }

    /**
     * @param $categoryID
     * @return array
     */
    public static function catGetSubCategories($categoryID)
    {
        if (is_int($categoryID)) {
            $categories = SCCategories::find()->select(['categoryID'])->where('categoryID > 0')->andWhere(['in', 'parent', $categoryID])->all();
        } else {
            $ar = array();

            foreach ($categoryID as $c) {
                $ar[] = $c->categoryID;
            }

            $categories = SCCategories::find()->select(['categoryID'])->where('categoryID > 0')->andWhere(['in', 'parent', $ar])->all();
        }

        if ($categories) {
            $categories = array_merge($categories, SCCategories::catGetSubCategories($categories));
        }

        return $categories;
    }

    /**
     * @param $categoryID
     * @return array
     */
    public static function catGetSubCategoriesIds($categoryID)
    {
        if (is_int($categoryID)) {
            $categories = SCCategories::findWithParentsById($categoryID)->select(['categoryID'])->andWhere('categoryID > 0')->andWhere(['in', 'parent', $categoryID])->all();
        } else {
            $ar = array();

            foreach ($categoryID as $c) {
                $ar[] = $c->categoryID;
            }

            $categories = SCCategories::findWithParentsById($categoryID)->select(['categoryID'])->andWhere('categoryID > 0')->andWhere(['in', 'parent', $ar])->all();
        }
        if ($categories) {
            $categories = array_merge($categories, SCCategories::catGetSubCategories($categories));
        }

        $ret = [];

        foreach ($categories as $c) {
            $ret[] = $c->categoryID;
        }

        return $ret;
    }

    /**
     * @param $categoryID
     * @return array
     */
    public static function catGetParentPath($categoryID)
    {
        $current_offset = $categoryID;

        $array = array();

        $array[] = $current_offset;

        while ($current_offset != 1) {
            $current_cat = SCCategories::find()->where("categoryID = $current_offset")->one();

            $leveldown = SCCategories::find()->where("categoryID = $current_cat->parent")->one();

            $current_offset = $leveldown->categoryID;

            $array[] = $current_offset;
        }

        return $array;
    }

    public function generateMetaInPath()
    {
        /*
        $path = $this->path;

        $path[] = $this->categoryID;

        foreach ($path as $p){
            $cat = SCCategories::findOne($p);
            $cat->generateMeta();
        }
        */
    }

    public function generateMeta()
    {
        $meta = [];

        $subcategoryies = SCCategories::findWithInner($this->categoryID)->all();

        $subcategory_ids = [];

        $subcategory_ids[] = $this->categoryID;

        foreach ($subcategoryies as $sub){
            $subcategory_ids[] = $sub->categoryID;
        }

        $inner = SCParentalConnections::find()->select('categoryID')->where(['in','parent',$subcategory_ids])->all();

        foreach ($inner as $i){
            $subcategory_ids[] = $i->categoryID;
        }

        $meta['categoryID'] = $this->categoryID;
        $meta['countChildren'] = (int)SCCategories::find()->where(['parent' => $this->categoryID])->count();
        $meta['countAllChildren'] = (int)SCCategories::find()->where(['in', 'parent', $subcategory_ids])->count();
        $meta['countProducts'] = (int)SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->count();
        $meta['countInStock'] = (int)SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->andWhere('in_stock > 0')->count();
        $meta['countActionInStock'] = (int)SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->andWhere('list_price > Price')->andWhere('in_stock > 0')->count();
        if ($meta['countInStock'] > 0) {
            $meta['minPrice'] = (int)SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->andWhere('Price > 0')->andWhere('in_stock > 0')->min('Price');
        } else {
            $meta['minPrice'] = (int)SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->andWhere('Price > 0')->min('Price');
        }
        $meta['minActionPrice'] = (int)SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->andWhere('Price > 0')->andWhere('in_stock > 0')->andWhere('list_price > Price')->min('Price');
        $meta['minListPrice'] = (int)SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->andWhere('list_price > 0')->andWhere('Price > 0')->min('list_price');
        $meta['maxPrice'] = (int)SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->max('Price');
        $meta['maxListPrice'] = (int)SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->andWhere('list_price > 0')->max('list_price');


        $meta['hasAction'] = 0;


        if ($meta['minPrice'] < $meta['minListPrice']) {
            $meta['hasAction'] = 1;
        }



        $this->meta_data = Json::encode($meta);

        if (!$this->save()) {
            throw new \Exception("Exception");
        }
    }

    public function generateMetaPrices(){
        $subcategoryies = SCCategories::findWithInner($this->categoryID)->all();
        $subcategory_ids = [];
        $subcategory_ids[] = $this->categoryID;
        foreach ($subcategoryies as $sub){
            $subcategory_ids[] = $sub->categoryID;
        }
        $inner = SCParentalConnections::find()->select('categoryID')->where(['in','parent',$subcategory_ids])->all();
        foreach ($inner as $i){
            $subcategory_ids[] = $i->categoryID;
        }
        if(empty($this->meta_data)) return;
        $meta = Json::decode($this->meta_data);

        $getActions = SCProducts::find()->where(['in', 'categoryID', $subcategory_ids])->all();
        $countActions = 0;
        foreach($getActions as $ga){
            $ep = $ga->extraPrices;
            if(!empty($ep)){
                foreach($ep as $ep){
                    if($ep->Price > $ep->list_price) $countActions++;
                    if($meta['minPrice'] > $ep->Price) $meta['minPrice'] = $ep->Price;
                    if($meta['maxPrice'] < $ep->Price) $meta['maxPrice'] = $ep->Price;
                    if($meta['minListPrice'] > $ep->list_price && $ep->list_price <> 0) $meta['minListPrice'] = $ep->list_price;
                    if($meta['maxListPrice'] < $ep->list_price && $ep->list_price <> 0) $meta['maxListPrice'] = $ep->list_price;
                }
            }
            if($ga->Price < $ga->list_price) $countActions++;
            if($meta['minPrice'] > $ga->Price) $meta['minPrice'] = $ga->Price;
            if($meta['maxPrice'] < $ga->Price) $meta['maxPrice'] = $ga->Price;
            if($meta['minListPrice'] > $ga->list_price && $ga->list_price <> 0) $meta['minListPrice'] = $ga->list_price;
            if($meta['maxListPrice'] < $ga->list_price && $ga->list_price <> 0) $meta['maxListPrice'] = $ga->list_price;

        }

        if ($meta['minPrice'] < $meta['minListPrice']) {
            $meta['hasAction'] = 1;
        }


        $this->meta_data = Json::encode($meta);

        if (!$this->save()) {
            throw new \Exception("Exception");
        }
    }

    public function resetMeta()
    {
/*        $pathB = $this->path;

        foreach ($pathB as $p) {
            $path[] = $p['id'];
        }

        $path[] = $this->categoryID;

        //SCCategories::updateAll(['meta_data'=>null],['in', 'categoryID', $path]);
        SCCategoryMeta::deleteAll(['in', 'categoryID', $path]);*/
    }

    public function resetCache()
    {
        $pathB = $this->path;

        foreach ($pathB as $p) {
            $path[] = $p['id'];
        }

        $path[] = $this->categoryID;

        TagDependency::invalidate(Yii::$app->dbCache, 'category_' . $this->categoryID);

        foreach ($this->products as $p){
            TagDependency::invalidate(Yii::$app->dbCache, 'product_' . $p->productID);
        }
    }

    /**
     * @return mixed
     */
    public static function returnRecursiveTree()
    {
        $key = 'catTreeRecurs';

        $cache = Yii::$app->cache;

        $ct = $cache->getOrSet($key, function () {
            return SCCategories::buildRecursiveTree(1);
        }, 86400, new TagDependency(['tags' => 'catTreePath']));

        return $ct;
    }

    /**
     * @param int $parent
     * @param int $level
     * @return array
     */
    public static function buildTree($parent = 0, $level = 0)
    {
        $tree = [];

        $models = SCCategories::find()->select(['categoryID', 'name_ru'])->where(['parent' => $parent])->orderBy('name_ru ASC')->all();

        if (empty($models)) return [];

        foreach ($models as $m) {
            $tree[] = ['categoryID' => $m->categoryID, 'name_ru' => str_repeat(' - ', $level) . $m->name_ru];

            $tree = array_merge($tree, SCCategories::buildTree($m->categoryID, $level + 1));
        }

        return $tree;
    }

    /**
     * @param int $parent
     * @param array $tree
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function buildRecursiveTree($parent = 0, $tree = [])
    {
        $models = SCCategories::getDb()->cache(function ($db) use ($parent) {
            return SCCategories::find()->select(['categoryID', 'name_ru'])->where(['parent' => $parent])->orderBy('sort_order ASC')->all();
        });

        if (empty($models)) return [];

        foreach ($models as $m) {
            $tree[$m->categoryID] = ['categoryID' => $m->categoryID, 'name_ru' => $m->name_ru];

            $tree[$m->categoryID]['nodes'] = SCCategories::buildRecursiveTree($m->categoryID);
        }

        return $tree;
    }

    /**
     * @param int $parent
     * @param string $string
     * @return mixed
     */
    public static function buildTreePath($parent = 0, $string = "")
    {
        //TagDependency::invalidate(Yii::$app->cache, 'catTreePath');
        $key = 'catTreePath';

        $cache = Yii::$app->cache;

        $ct = $cache->getOrSet($key, function () use ($parent) {
            $tree = [];

            $models = SCCategories::find()->select(['categoryID', 'name_ru'])->where(['parent' => $parent])->orderBy('name_ru ASC')->all();

            if (empty($models)) return [];

            foreach ($models as $m) {
                if (!empty($string))
                    $ns = $string . ' / ' . $m->name_ru;
                else
                    $ns = $m->name_ru;

                $tree[] = ['categoryID' => $m->categoryID, 'name_ru' => $ns];

                $tree = array_merge($tree, SCCategories::buildTreePathSub($m->categoryID, $ns));
            }
            return $tree;
        }, 86400, new TagDependency(['tags' => 'catTreePath']));

        return $ct;
    }

    /**
     * @param int $parent
     * @param string $string
     * @return array
     */
    public static function buildTreePathSub($parent = 0, $string = "")
    {
        $tree = [];

        $models = SCCategories::find()->select(['categoryID', 'name_ru'])->where(['parent' => $parent])->orderBy('name_ru ASC')->all();

        if (empty($models)) return [];

        foreach ($models as $m) {
            if (!empty($string))
                $ns = $string . ' / ' . $m->name_ru;
            else
                $ns = $m->name_ru;

            $tree[] = ['categoryID' => $m->categoryID, 'name_ru' => $ns];

            $tree = array_merge($tree, SCCategories::buildTreePathSub($m->categoryID, $ns));
        }

        return $tree;
    }

    /**
     * @param $tag
     * @return mixed
     */
    public static function normalizeTag($tag){
        $str = str_replace('_',' ', $tag);

        $str = str_replace('-',' ', $str);

        $cyr = [
            'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
            'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
            'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
            'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
        ];

        $lat = [
            'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
            'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya',
            'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P',
            'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
        ];

        $str = str_replace($lat,$cyr, $str);

        return $str;
    }


    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function buildLinkage()
    {
        $m = CategoryInfo::find()->where(['category_id'=>$this->categoryID])->one();

        if(empty($m)){
            $m = new CategoryInfo();
            $m->category_id = $this->categoryID;
        }

        $m->name = $this->name_ru;

        $m->description = $this->description_ru;

        $m->picture = $this->picture;

        $m->save();

        SettingModel::updateAll(['value'=>Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i')],['section'=>'market', 'key'=>'lastupdate']);
    }
}
