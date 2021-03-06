<?php
/**
 * Created by PhpStorm.
 * User: Lakkinzi
 * Date: 1/31/2019
 * Time: 16:41
 */

namespace console\controllers;

use yii\console\Controller;
use common\models\SCProductsParsing;
use common\models\SCProducts;
use common\models\SCParsing;
use XLSXWriter;
class ParsingController extends Controller
{
//    protected $base;

    public function actionIndex()
    {



//        $p = new ParserController('https://fmagazin.ru/banax/snasti/udilisha/nahlystovie_udulisha/udilishe_banax_mega_fly.mfl9064.html',  1, true);
//        $p->crawl();
//#prod-price-box > div.prod-price-value > span
//       #content > h1
//        $p = new ParserController('https://fmagazin.ru/shimano/snasti/katushki/zapasnye_shpuli/nakladka_ekonomayzer_na_shpulyu_shimano_match_line_reducer.rd15384.html',  1, true);
//        $p->crawl();
//#prod-price-box > div.prod-price-value > span
//#content > h1
                $p = new ParserController('https://fmagazin.ru/', true);
        $p->crawl();

    }



    public function actionList()
    {
        $date = date('d.m.y');
        $header = array(
            'ID' => 'integer',
            'Rybalka-shop name' => 'string',
            'Price' => 'integer',
            'FMagazin name' => 'string',
            'EvilPrice' => 'integer',


        );

        $headerStyle = array(
            'font' => 'Arial',
            'font-size' => 12,
            'font-style' => 'bold',
            'halign' => 'center',
            'border' => 'left,right,top,bottom',
            'border-style' => 'medium',
            'widths' => [8, 50, 10, 50, 10],

        );

        $tableStyleBadPrice = array(
            'height' => 20,
            ['fill' => '#ffffff',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',
            ],

            ['fill' => '#ffffff',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',],

            ['fill' => '#B0E0E6',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',],

            ['fill' => '#ffffff',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',],
            ['fill' => '#ff00ff',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',]
        );

        $tableStyleGoodPrice = array(
            'height' => 20,

            ['fill' => '#ffffff',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',],

            ['fill' => '#ffffff',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',],

            ['fill' => '#B0E0E6',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',],

            ['fill' => '#ffffff',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',],
            ['fill' => '#B0E0E6',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',]
        );

        $tableStyleNoPrices = array(
            'height' => 20,

            ['fill' => '#ffffff',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',],

            ['fill' => '#ffffff',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',],

            ['fill' => '#B0E0E6',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',],

            ['fill' => '#ffffff',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',],
            ['fill' => '#808080',
                'wrap_text' => true,
                'border' => 'top,bottom,left,right',
                'border-style' => 'thin',
                'halign' => 'center',]
        );

        $writer = new XLSXWriter();

        $r = 2;
        $ourProducts = SCProducts::find()->select(['productID', 'name_ru', 'Price'])->with('parsing')->limit(1000)->all();
        $count = 0;

        $print = [];

        foreach ($ourProducts as $productID => $product) {
            if (!empty($product->parsing)) {

                $print[$productID]['id'] = $product->productID;
                $print[$productID]['name_ru'] = $product->name_ru;
                $print[$productID]['Price'] = $product->Price;
                $print[$productID]['enemyNames'] = $product->parsing[0]->name;
                $print[$productID]['enemyPrices'] = $product->parsing[0]->price;

//                $print[$productID]['enemyPrices'] = Json::encode($product->parsing);
            } else {
                $print[$productID]['id'] = $product->productID;
                $print[$productID]['name_ru'] = $product->name_ru;
                $print[$productID]['Price'] = $product->Price;
                $print[$productID]['enemyNames'] = 'НЕТ В НАЛИЧИИ';
                $print[$productID]['enemyPrices'] = 0;
            }

        }

        $parsProducts = SCParsing::find()->select(['id', 'name', 'price'])->with('products')->limit(1000)->all();


        $writer->writeSheetHeader('PRICELIST', $header, $headerStyle);
        $rowdata = array();
        $rowstyle = array();
        foreach ($print as $p) {
            if ($p['enemyPrices'] < $p['Price'] && $p['enemyPrices'] != 0) {
                $writer->writeSheetRow('PRICELIST', $p, $tableStyleBadPrice);

            }
            if ($p['enemyPrices'] >= $p['Price']) {
                $writer->writeSheetRow('PRICELIST', $p, $tableStyleGoodPrice);
            }
            if ($p['enemyPrices'] == 0) {
                $writer->writeSheetRow('PRICELIST', $p, $tableStyleNoPrices);
            }
            $r = $r + 1;
        }
        $writer->writeToFile($date . ' Prices.xlsx');
//        $time = microtime(true) - $start;
//        var_dump($time);
    }


    public function actionCompare()
    {
//global $base;
        set_time_limit(0);
        global $id;
        $ourProducts = SCProducts::find()->select(['name_ru', 'productID'])->asArray()->all();
        $parsingProducts = SCParsing::find()->select(['name', 'id'])->asArray()->all();
        global $i;
        $start = microtime();
        foreach ($ourProducts as $name_ru => $product) {

            $prodName = $product['name_ru'];    //Имя продукта
            $prodID = $product['productID'];     //ID продукта




            $percent = 0;
            $thisPars = ['id' => 0, 'percent' => 0, 'name' => ' '];     //Массив для промежуточного сохранения
//            $pars = preg_replace('/[^a-z0-9,]/iu', '', $pars);

            foreach ($parsingProducts as $name => $parsing) {
                $parsName = $parsing['name'];       //Имя парсинг-продукта
                $parsID = $parsing['id'];       //ID парсинг-продукта
//                $prod = preg_replace('/[^a-z0-9,]/iu', '', $prod);

                similar_text($prodName, $parsName, $percent);
                if ($percent > $thisPars['percent']) {
                    $thisPars['percent'] = $percent;
                    $thisPars['id'] = $parsID;
                    $thisPars['name'] = $parsName;
                }
            }

            $truePars = $thisPars['id'];
            $trueName = $thisPars['name'];

            $ProductsParsing = new SCProductsParsing();


            $ProductsParsing->product_name = $prodName;
            $ProductsParsing->parsing_name = $trueName;
            $ProductsParsing->parsing_id = $truePars;
            $ProductsParsing->product_id = $prodID;
            $ProductsParsing->save();
            var_dump($start);
        }

    }

}

//foreach ($ourProducts as $name_ru => $product) {
//
//    $prodName = $product['name_ru'];    //Имя продукта
//    $prodID = $product['productID'];     //ID продукта
//
//
//    $percent = 0;
//    $thisPars = ['id' => 0, 'percent' => 0, 'name' => ' '];     //Массив для промежуточного сохранения
////            $pars = preg_replace('/[^a-z0-9,]/iu', '', $pars);
//
//    foreach ($parsingProducts as $name => $parsing) {
//
//        $parsName = $parsing['name'];       //Имя парсинг-продукта
//        $parsID = $parsing['id'];       //ID парсинг-продукта
////                $prod = preg_replace('/[^a-z0-9,]/iu', '', $prod);
//
//        similar_text($prodName, $parsName, $percent);
//        if ($percent > $thisPars['percent']) {
//            $thisPars['percent'] = $percent;
//            $thisPars['id'] = $parsID;
//            $thisPars['name'] = $parsName;
//        }
//    }
//
//    $truePars = $thisPars['id'];
//    $trueName = $thisPars['name'];
//
//    $ProductsParsing = new SCProductsParsing();
//
//
//    $ProductsParsing->product_name = $prodName;
//    $ProductsParsing->parsing_name = $trueName;
//    $ProductsParsing->parsing_id = $truePars;
//    $ProductsParsing->product_id = $prodID;
//    $ProductsParsing->save();



//    var_dump($start);
//}
//            static $seen = array();
//            if (isset($seen[$url]) || $depth === 6) {
//                if($depth === 6){
//                    $depth = 1;
//                    return;
//                }
//            }
//            $seen[$url] = true; //проиндексировано!


//            @$dom = new \DOMDocument('1.0'); //Удобнее всего - через объект DOMDocument
//            @$dom->loadHTMLFile($url);