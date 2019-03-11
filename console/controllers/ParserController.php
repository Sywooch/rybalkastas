<?php

namespace console\controllers;


use GuzzleHttp\Client;
use common\models\SCParsing;
use common\models\SCParsingLinks;
use phpQuery;


class ParserController
{

    private $url;
    private $selectorName;
    private $selectorPrice1;
    private $selectorPrice2;
    private $selectorPrice3;
    private $results = array();
    private $same_host = false;
    private $host;


    public function setHost($host)
    {
        $this->host = $host;
    }

    public function getResults()
    {
        return $this->results;
    }

    public function setSameHost($same_host)
    {
        $this->same_host = $same_host;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        $this->setHost($this->getHostFromUrl($url));
    }

    public function setSelectorPrice($selectorPrice1, $selectorPrice2, $selectorPrice3)
    {
        $this->selectorPrice1 = $selectorPrice1;
        $this->selectorPrice2 = $selectorPrice2;
        $this->selectorPrice3 = $selectorPrice3;
    }

    public function setSelectorName($selectorName)
    {
        $this->selectorName = $selectorName;
    }

    public function __construct($url = null,
                                $same_host = false, $selectorName,
                                $selectorPrice1, $selectorPrice2, $selectorPrice3)
    {
        if (!empty($url)) $this->setUrl($url);
        if (!empty($selectorName)) $this->setSelectorName($selectorName);
        if (!empty($selectorPrice1))
            $this->setSelectorPrice($selectorPrice1,
                $selectorPrice2, $selectorPrice3);
        $this->setSameHost($same_host);

    }


    //MAIN METHOD
    public function crawl()
    {

        if (empty($this->url)) throw new \Exception('URL not set!');

        $this->_crawl($this->url, $this->selectorName, $this->selectorPrice1, $this->selectorPrice2, $this->selectorPrice3);

        return $this->results;

    }


    public function _crawl($url, $selectorName, $selectorPrice1, $selectorPrice2, $selectorPrice3)
    {
//        static $seen = array();
        $mainUrl = $this->url;

//sleep(2);
        $today = time();
        $seenLinks = new SCParsingLinks;
        $seenLinks->links = $url;
        $currentUrlParsing = SCParsingLinks::find()->where(['links' => $url])->one();
//var_dump($currentUrlParsing);
        if ($currentUrlParsing != null) {
            $parsTime = $currentUrlParsing->created_at;
            $diffTime = $today - $parsTime;
        }

//        if (isset($seen[$url])) return;


//        $diffTime < 20000 &&
//        $diffTime != 0 &&
//        $currentUrlParsing != $mainUrl
        if ($currentUrlParsing) return;

        try {
            $client = new Client();
            if (empty($client)) {
                var_dump('not client');
            }
            $res = $client->request('GET', $url);


            $body = $res->getBody();
            if (empty($body)) {
                var_dump('not $body');
            }

//            $body = mb_convert_encoding($this->results, 'utf-8', 'auto');
            $document = \phpQuery::newDocumentHTML($body);

            $name = (string)$document->find($selectorName);
            $name1 = '';
            $name = strip_tags($name, $name1);
            $name1 = preg_replace("/Комментарии |Вопросы |Отзывы |Обзоры /", '', $name);
            $name1 = preg_replace("/[\—\(\)]+ /", '', $name1);

//            if (empty($name)) {
//                var_dump('not $name');
//            }


            $price1 = (string)$document->find($selectorPrice1);
            $price2 = (string)$document->find($selectorPrice2);
            $price3 = (string)$document->find($selectorPrice3);

            if (!empty($price1))
                $truePrice = $price1;
            elseif (!empty($price2))
                $truePrice = $price2;
            elseif (!empty($price3))
                $truePrice = $price3;

//            if (empty($truePrice)) {
//                var_dump('not price');
//            }

//            else var_dump('price Empty');



            $prices[] = '';

if(!empty($truePrice))
{
    $truePrice = preg_match("/\d+/", $truePrice, $prices);
}
            $truePrice = $prices[0];

//            var_dump('step');
//            var_dump($url);

            if ($url == "https://fmagazin.ru/daiwa/snasti/katushki/bezynertsionnye/peredniy_friction/katushka_daiwa_regal_5ia.html"||
                $url == 'https://www.fmagazin.ru/daiwa/snasti/katushki/bezynertsionnye/peredniy_friction/katushka_daiwa_regal_5ia.html'||
                $url == 'http://www.fmagazin.ru/abu_garcia/snasti/primanki/voblery/jerkbait/vobler_abu_garcia_hi_lo_jerkbait.html' ||
                $url == 'http://www.fmagazin.ru/pontoon21/snasti/primanki/voblery/shad/vobler_pontoon_21_kalikana_dun.html'||
                $url == 'https://www.fmagazin.ru/pontoon21/snasti/primanki/voblery/shad/vobler_pontoon_21_kalikana_dun.html' ||
                $url == 'https://www.fmagazin.ru/pontoon21/snasti/primanki/voblery/shad/vobler_pontoon_21_kalikana_dun.html')
            {
                var_dump('START BEFORE');
                var_dump($truePrice);
                var_dump("Имя", $name);
                var_dump($url);
                var_dump('END BEFORE');
                die;
            }

            if(!empty($truePrice))
            {

            $truePrice = (double)$truePrice;
            $parsProduct = new SCParsing();

            $parsProduct->price = $truePrice;
            $parsProduct->link = $url;
            $parsProduct->name = $name;
//                $parsProduct->time = $today;
            $parsProduct->host = $this->url;

            $parsProduct->save();


//            if ($url = "https://fmagazin.ru/yo_zuri/snasti/primanki/voblery/rattlin/vobler_yo_zuri_hardcore_fintail_vibe.html") {
//                var_dump('START AFTER');

                if ($url == "https://fmagazin.ru/daiwa/snasti/katushki/bezynertsionnye/peredniy_friction/katushka_daiwa_regal_5ia.html"||
                    $url ==  'https://www.fmagazin.ru/daiwa/snasti/katushki/bezynertsionnye/peredniy_friction/katushka_daiwa_regal_5ia.html'||
                    $url == 'http://www.fmagazin.ru/abu_garcia/snasti/primanki/voblery/jerkbait/vobler_abu_garcia_hi_lo_jerkbait.html' ||
                    $url == 'http://www.fmagazin.ru/pontoon21/snasti/primanki/voblery/shad/vobler_pontoon_21_kalikana_dun.html'||
                    $url == 'https://www.fmagazin.ru/pontoon21/snasti/primanki/voblery/shad/vobler_pontoon_21_kalikana_dun.html' ||
                    $url == 'https://www.fmagazin.ru/pontoon21/snasti/primanki/voblery/shad/vobler_pontoon_21_kalikana_dun.html'
                   ) {
                    var_dump('no product');
                    var_dump($truePrice);
                    var_dump($name);
                    var_dump($url);
                    var_dump('END AFTER');
                    var_dump('is product');
                    die;

                }

            }


        } catch (\Exception $ex) {
//            var_dump('error');

        }

        $seenLinks->save();
        $seen[$url] = true;
        $dom = new \DOMDocument('1.0');
        @$dom->loadHTMLFile($url);
        $this->results[] = array( //Массив результатов сканирования
            'url' => $url,
            'content' => @$dom->saveHTML()
        );


        $anchors = $dom->getElementsByTagName('a');
        foreach ($anchors as $element) {

            if (!$href = $this->buildUrl($url, $element->getAttribute('href')))
            {
                var_dump($url)  ;
                var_dump('no');
                continue;
            }
//            var_dump($href)  ;
//
//            var_dump('yes');
            $this->_crawl($href, $selectorName, $selectorPrice1, $selectorPrice2, $selectorPrice3);


        }


        return $url;
    }


    private function buildUrl($url, $href)
    { //Построение URL

        $url = trim($url);
        $href = trim($href);
        if (strpos($href, 'http') !== 0 ||strpos($href, 'https') !== 0) {
            //Не сканируем яваскрипт и внутренние якоря:
            if (strpos($href, 'javascript:') === 0 || strpos($href, '#') === 0) return false;
            //Остальное смотрим:
            $path = '/' . ltrim($href, '/');
            if (extension_loaded('http'))
                $new_href = http_build_url($url, array('path' => $path), HTTP_URL_REPLACE, $parts);
            else {
                $parts = parse_url($url);
                $new_href = $this->buildUrlFromParts($parts);
                $new_href .= $path;
            }
            //Относительные адреса, типа ./page.php
            if (strpos($href, './') && !empty($parts['path']) === 0) { //Путь не заканчивантся слешем
                if (!preg_match('@/$@', $parts['path'])) {
                    $path_parts = explode('/', $parts['path']);
                    array_pop($path_parts);
                    $parts['path'] = implode('/', $path_parts) . '/';
                }
                $new_href = $this->buildUrlFromParts($parts) . $parts['path'] . ltrim($href, './');
            }
            $href = $new_href;
        }
        if ($this->same_host && $this->host != $this->getHostFromUrl($href)) return false;
        return $href;

    }

    private function buildUrlFromParts($parts)
    {
        $new_href = $parts['scheme'] . '://';
        if (isset($parts['user']) && isset($parts['pass']))
            $new_href .= $parts['user'] . ':' . $parts['pass'] . '@';
        $new_href .= $parts['host'];
        if (isset($parts['port'])) $new_href .= ':' . $parts['port'];
        return $new_href;
    }

    private function getHostFromUrl($url)
    {
        $parts = parse_url($url);
        preg_match("@([^/.]+)\.([^.]{2,6}(?:\.[^.]{2,3})?)$@", $parts['host'], $host);
        return array_shift($host);
    }

}


//private $depth = 2;
//private $url;
//private $results = array();
//private $same_host = false;
//private $host;
//
//public function setDepth($depth)
//{
//    $this->depth = $depth;
//}
//
//public function setHost($host)
//{
//    $this->host = $host;
//}
//
//public function getResults()
//{
//    return $this->results;
//}
//
//public function setSameHost($same_host)
//{
//    $this->same_host = $same_host;
//}
//
//public function setUrl($url)
//{
//    $this->url = $url;
//    $this->setHost($this->getHostFromUrl($url));
//}
//
//public function __construct($url = null, $depth = null, $same_host = false)
//{
//    if (!empty($url)) $this->setUrl($url);
//    if (isset($depth) && !is_null($depth)) $this->setDepth($depth);
//    $this->setSameHost($same_host);
//}
//
//public function crawl()
//{
//    if (empty($this->url)) throw new \Exception('URL not set!');
//    $this->_crawl($this->url, $this->depth);
//    return $this->results;
//}
//
//public function _crawl($url, $depth)
//{
//
//
//    static $seen = array();
//    if (empty($url)) return;
//    if (!$url = $this->buildUrl($this->url, $url)) return;
//    if ($depth === 0 || isset($seen[$url])) return;
//    $seen[$url] = true;
//    $dom = new \DOMDocument('1.0');
//    @$dom->loadHTMLFile($url);
//    $this->results[] = array( //Массив результатов сканирования
//        'url' => $url,
//        'content' => @$dom->saveHTML()
//    );
//    var_dump($url);
//    $anchors = $dom->getElementsByTagName('a');
//    foreach ($anchors as $element) {
//        if (!$href = $this->buildUrl($url, $element->getAttribute('href'))) continue;
//        $this->_crawl($href, $depth - 1);
//    }
//    try {
//        $client = new Client();
//        $res = $client->request('GET', $url);
//
//
//        $body = $res->getBody();
//
////            $body = mb_convert_encoding($this->results, 'utf-8', 'auto');
//        $document = \phpQuery::newDocumentHTML($body);
//
//        $name = (string)$document->find('#content > h1');
//        $name = preg_replace("~</?h1[^>]*>~", '', $name);
//        $name = preg_replace("/Комментарии |Вопросы |Отзывы |Обзоры /", '', $name);
//        $name = preg_replace("/[\—\(\)]+ /", '', $name);
//
//        $price = (string)$document->find('#prod-price-box > div.prod-price-value > span');
//        $prices[] = '';
//        $price = preg_match("/\d+/", $price, $prices);
//        $price = $prices[0];
//        $price = (double)$price;
//
//
//
//        $parsProduct = new SCParsing();
//
//
//
//        $parsProduct->price = $price;
//        $parsProduct->link = $this->url;
//        $parsProduct->name = $name;
//
//        $parsProduct->save();
//
//
//        if ($price != 0) {
//            var_dump($price);
//            var_dump($name);
//        }
//    } catch (\Exception $ex) {
//    }
//    return $url;
//}
//
//private function buildUrl($url, $href)
//{ //Построение URL
//    $url = trim($url);
//    $href = trim($href);
//    if (strpos($href, 'http') !== 0) {
//        //Не сканируем яваскрипт и внутренние якоря:
//        if (strpos($href, 'javascript:') === 0 || strpos($href, '#') === 0) return false;
//        //Остальное смотрим:
//        $path = '/' . ltrim($href, '/');
//        if (extension_loaded('http'))
//            $new_href = http_build_url($url, array('path' => $path), HTTP_URL_REPLACE, $parts);
//        else {
//            $parts = parse_url($url);
//            $new_href = $this->buildUrlFromParts($parts);
//            $new_href .= $path;
//        }
//        //Относительные адреса, типа ./page.php
//        if (strpos($href, './') && !empty($parts['path']) === 0) { //Путь не заканчивантся слешем
//            if (!preg_match('@/$@', $parts['path'])) {
//                $path_parts = explode('/', $parts['path']);
//                array_pop($path_parts);
//                $parts['path'] = implode('/', $path_parts) . '/';
//            }
//            $new_href = $this->buildUrlFromParts($parts) . $parts['path'] . ltrim($href, './');
//        }
//        $href = $new_href;
//    }
//    if ($this->same_host && $this->host != $this->getHostFromUrl($href)) return false;
//    return $href;
//}
//
//private function buildUrlFromParts($parts)
//{
//    $new_href = $parts['scheme'] . '://';
//    if (isset($parts['user']) && isset($parts['pass']))
//        $new_href .= $parts['user'] . ':' . $parts['pass'] . '@';
//    $new_href .= $parts['host'];
//    if (isset($parts['port'])) $new_href .= ':' . $parts['port'];
//    return $new_href;
//}
//
//private function getHostFromUrl($url)
//{
//    $parts = parse_url($url);
//    preg_match("@([^/.]+)\.([^.]{2,6}(?:\.[^.]{2,3})?)$@", $parts['host'], $host);
//    return array_shift($host);
//}




