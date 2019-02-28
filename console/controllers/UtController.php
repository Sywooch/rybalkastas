<?php

namespace console\controllers;

use common\components\UtQuery;
use common\components\UtUploader;
use common\models\mongout\Barcodes;
use common\models\mongout\Customers;
use common\models\mongout\Orders;
use common\models\mongout\Products;
use common\models\mongout\Statuses;
use common\models\mongout\Users;
use common\models\mongout\Warehouses;
use common\models\SCCategories;
use common\models\SCExperts;
use common\models\SCNewsTable;
use common\models\SCOrders;
use common\models\SCOrderStatus;
use common\models\SCProducts;
use common\models\CartElement;
use MongoDB\BSON\ObjectId;
use yii\base\Security;
use yii\console\Controller;
use \Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\Application;
use yii\web\User;

class UtController extends Controller
{
    public function actionSetUser(){
        $user = Users::findOne(['_id'=>new ObjectId('5b431b9165265223034bc4d1')]);
        $user->login = 'alexey';
        $user->password_hash = (new Security())->generatePasswordHash('123456');
        $user->save();
    }


    public function actionFillWarehouses()
    {
        $ar = UtQuery::runQuery('ВЫБРАТЬ * ИЗ Справочник.Склады КАК Склады');
        foreach ($ar as $a) {
            $model = new Warehouses();
            $model->takeNeeded($a);
            $model->save();
        }
    }

    public function actionFillBarcodes()
    {
        $times = 1000;
        $perpage = 10000;

        $i = 1;
        while ($i <= $times) {
            $ar = UtQuery::runQuery('ВЫБРАТЬ Штрихкоды.Штрихкод, Штрихкоды.Владелец.Ссылка, Штрихкоды.Владелец.Код ИЗ РегистрСведений.Штрихкоды КАК Штрихкоды', (($i*$perpage)-($perpage-1)), $i*$perpage);
            if(empty($ar))break;
            foreach ($ar as $a) {
                $model = new Barcodes();
                $model->takeNeeded($a);
                $model->save();
            }
            echo "LOOP $i DONE".PHP_EOL;
            $i++;
        }
    }

    public function actionFillEverything()
    {
        $this->fillStatuses();
    }


    // Все функции заполнения:


    function fillWarehouses(){
        $ar = UtQuery::runQuery('ВЫБРАТЬ * ИЗ Справочник.Склады КАК Склады');
        foreach ($ar as $a) {
            $model = new Warehouses();
            $model->takeNeeded($a);
            $model->save();
        }
    }

    function fillBarcodes(){
        $times = 1000;
        $perpage = 10000;

        $i = 1;
        while ($i <= $times) {
            $ar = UtQuery::runQuery('ВЫБРАТЬ Штрихкоды.Штрихкод, Штрихкоды.Владелец.Ссылка, Штрихкоды.Владелец.Код ИЗ РегистрСведений.Штрихкоды КАК Штрихкоды', (($i*$perpage)-($perpage-1)), $i*$perpage);
            if(empty($ar))break;
            foreach ($ar as $a) {
                $model = new Barcodes();
                $model->takeNeeded($a);
                $model->save();
            }
            echo "LOOP $i DONE".PHP_EOL;
            $i++;
        }
    }

    function fillOrders(){
        $times = 1000;
        $perpage = 500;
        $baseQuery = <<<PHP_EOL
ВЫБРАТЬ
	ЗаказПокупателя.Ссылка КАК Ссылка,
	ЗаказПокупателя.Номер КАК Номер,
	ЗаказПокупателя.Дата КАК Дата,
	ЗаказПокупателя.Проведен КАК Проведен,
	ЗаказПокупателя.ДатаОплаты КАК ДатаОплаты,
	ЗаказПокупателя.ДатаОтгрузки КАК ДатаОтгрузки,
	ЗаказПокупателя.ДисконтнаяКарта.Ссылка КАК ДисконтнаяКартаСсылка,
	ЗаказПокупателя.Комментарий КАК Комментарий, 
	ЗаказПокупателя.Контрагент.Ссылка КАК КонтрагентСсылка,
	ЗаказПокупателя.Ответственный.Ссылка КАК ОтветственныйСсылка,
	ЗаказПокупателя.Подразделение.Ссылка КАК ПодразделениеСсылка,
	ЗаказПокупателя.СкладГруппа КАК СкладГруппа,
	ЗаказПокупателя.НомерВходящегоДокументаЭлектронногоОбмена КАК НомерВходящегоДокументаЭлектронногоОбмена,
	ЗаказПокупателя.ВидОплаты КАК ВидОплаты,
	ЗаказПокупателя.ВидДоставки КАК ВидДоставки,
	ЗаказПокупателя.ЯчейкаХранения.Ссылка КАК ЯчейкаХраненияСсылка,
	ЗаказПокупателя.ЗаказСобран КАК ЗаказСобран,
	ЗаказПокупателя.РегиональныйЗаказ КАК РегиональныйЗаказ,
	ЗаказПокупателя.Объединен КАК Объединен,
	ЗаказПокупателя.Оплачен КАК Оплачен,
	ЗаказПокупателя.Источник КАК Источник,
	ЗаказПокупателя.Товары.(
		Ссылка,
		НомерСтроки,
		ЕдиницаИзмерения,
		ЕдиницаИзмеренияМест,
		Количество,
		КоличествоМест,
		Коэффициент,
		Номенклатура,
		ПлановаяСебестоимость,
		ПроцентСкидкиНаценки,
		Размещение,
		СтавкаНДС,
		Сумма,
		СуммаНДС,
		ХарактеристикаНоменклатуры,
		Цена,
		ПроцентАвтоматическихСкидок,
		УсловиеАвтоматическойСкидки,
		ЗначениеУсловияАвтоматическойСкидки,
		КлючСтроки,
		СерияНоменклатуры,
		ГотовКОтправке
	) КАК Товары,
	ЗаказПокупателя.Услуги.(
		Ссылка,
		НомерСтроки,
		Содержание,
		Количество,
		Цена,
		Сумма,
		СтавкаНДС,
		СуммаНДС,
		Номенклатура,
		ПроцентСкидкиНаценки,
		ПроцентАвтоматическихСкидок,
		УсловиеАвтоматическойСкидки,
		ЗначениеУсловияАвтоматическойСкидки
	) КАК Услуги,
	ЗаказПокупателя.Сертификаты.(
		Ссылка,
		НомерСтроки,
		Номенклатура,
		ХарактеристикаНоменклатуры,
		СерияНоменклатуры,
		Сумма,
		СуммаИспользования
	) КАК Сертификаты
ИЗ
	Документ.ЗаказПокупателя КАК ЗаказПокупателя
PHP_EOL;
        $i = 1;
        while ($i <= $times) {
            $ar = UtQuery::runQuery($baseQuery, (($i*$perpage)-($perpage-1)), $i*$perpage);
            if(empty($ar))break;
            foreach ($ar as $a) {
                $model = new Orders();
                $model->takeNeeded($a);
                $model->save();
            }
            echo "LOOP $i DONE".PHP_EOL;
            $i++;
        }
    }

    function fillUsers(){
        $baseQuery = <<<PHP_EOL
ВЫБРАТЬ
	Пользователи.Ссылка,
	Пользователи.ЭтоГруппа,
	Пользователи.Код,
	Пользователи.Наименование
	ИЗ
	Справочник.Пользователи КАК Пользователи
PHP_EOL;

        $ar = UtQuery::runQuery($baseQuery);
        foreach ($ar as $a) {
            $model = new Users();
            $model->takeNeeded($a);
            $model->save();
        }
    }

    function fillCustomers(){
        $times = 1000;
        $perpage = 10000;
        $baseQuery = <<<PHP_EOL
ВЫБРАТЬ
	Контрагенты.Ссылка КАК Ссылка,
	Контрагенты.ЭтоГруппа КАК ЭтоГруппа,
	Контрагенты.Код КАК Код,
	Контрагенты.Наименование КАК Наименование,
	РейтингКонтрагентовОстатки.РейтингОстаток КАК Рейтинг,
	Контрагенты.Родитель.Ссылка КАК Родитель
ИЗ
	РегистрНакопления.РейтингКонтрагентов.Остатки КАК РейтингКонтрагентовОстатки
		ЛЕВОЕ СОЕДИНЕНИЕ Справочник.Контрагенты КАК Контрагенты
		ПО РейтингКонтрагентовОстатки.Контрагент = Контрагенты.Ссылка
PHP_EOL;



        $i = 1;
        while ($i <= $times) {
            $ar = UtQuery::runQuery($baseQuery, (($i*$perpage)-($perpage-1)), $i*$perpage);
            if(empty($ar))break;
            foreach ($ar as $a) {
                $model = new Customers();
                $model->takeNeeded($a);
                $model->save();
            }
            echo "LOOP $i DONE".PHP_EOL;
            $i++;
        }
    }

    function fillReservations()
    {

    }

    function fillStatuses(){
        $baseQuery = <<<PHP_EOL
ВЫБРАТЬ
	СтатусыЗаказа.Ссылка,
	ПРЕДСТАВЛЕНИЕ(СтатусыЗаказа.Ссылка) КАК Название,
	СтатусыЗаказа.Порядок
ИЗ
	Перечисление.СтатусыЗаказа КАК СтатусыЗаказа
PHP_EOL;

        $ar = UtQuery::runQuery($baseQuery);
        foreach ($ar as $a) {
            $model = new Statuses();
            $model->takeNeeded($a);
            $model->save();
        }
    }

    public function actionGetContragentStocks(){
        $baseQuery = <<<PHP_EOL
ВЫБРАТЬ
	НоменклатураКонтрагентов.Контрагент.Ссылка,
	НоменклатураКонтрагентов.Номенклатура.Ссылка,
	НоменклатураКонтрагентов.Остаток
ИЗ
	РегистрСведений.НоменклатураКонтрагентов КАК НоменклатураКонтрагентов
PHP_EOL;
        $ar = UtQuery::runQuery($baseQuery);
        print_r(count($ar));
    }

    public function actionXml(){
        $xml = new \SimpleXMLElement(file_get_contents('/var/www/html/uploads/data.xml'));
        $columns = [];
        $values = [];
        foreach($xml as $item){
            if(!empty($item->Name)) $columns[] = $item->Name;
            else break;
        }

        foreach($xml as $ik=>$item){
            if(empty($item->Value)) continue;
            //$values[$ik] = [];
            $value = $item->Value;
            $ar = [];
            foreach((array)$value as $k=>$element){

                $ar[(string)$columns[(int)$k]] = $element;
            }
            $values[] = $ar;
        }

        $count = count($values);
        $i = 0;
        foreach($values as $value){
            $i++;
            echo "$i/$count".PHP_EOL;
            /*$product = Products::findOne(['link'=>$value['product_link']]);
            if(empty($product)) continue;
            $provider = $product->stock_provider;
            foreach($provider as $k=>$v){
                if($v['link'] == $value['partner_link']){
                    $provider[$k]['count'] = $value['count'];
                    continue 2;
                }

                $provider[] = [
                    'link'=>$value['partner_link'],
                    'count'=>$value['count']
                ];
            }

            $product->stock_provider = $provider;
            $product->save();*/
            Products::updateAll(['stock_provider_obj.'.$value['partner_link'] => $value['count']],['link'=>$value['product_link']]);
        }
    }

    public function actionCheckUt(){
        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
        echo file_get_contents($url);
    }
}