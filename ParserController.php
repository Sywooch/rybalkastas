<?php
namespace console\controllers;


use GuzzleHttp\Client;
use common\models\SCParsing;




class ParserController
{

    private $url;
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

    public function __construct($url = null, $same_host = false)
    {
        if (!empty($url)) $this->setUrl($url);
        $this->setSameHost($same_host);
    }



    //MAIN METHOD
    public function crawl()
    {
        if (empty($this->url)) throw new \Exception('URL not set!');
        $this->_crawl($this->url);
        return $this->results;
    }




    public function _crawl($url)
    {


        static $seen = array();

        if (isset($seen[$url])) return;
                try {
            $client = new Client();
            $res = $client->request('GET', $url);


            $body = $res->getBody();

//            $body = mb_convert_encoding($this->results, 'utf-8', 'auto');
            $document = \phpQuery::newDocumentHTML($body);

            $name = (string)$document->find('#content > h1');
            $name = preg_replace("~</?h1[^>]*>~", '', $name);
            $name = preg_replace("/Комментарии |Вопросы |Отзывы |Обзоры /", '', $name);
            $name = preg_replace("/[\—\(\)]+ /", '', $name);
            $price = (string)$document->find('#prod-price-box > div.prod-price-value > span');
            $prices[] = '';
            $price = preg_match("/\d+/", $price, $prices);
            $price = $prices[0];
            $price = (double)$price;

            $parsProduct = new SCParsing();
            $parsProduct->price = $price;
            $parsProduct->link = $this->url;
            $parsProduct->name = $name;
            $parsProduct->save();
            unset($parsProduct);

        } catch (\Exception $ex) {
        }

        $seen[$url] = true;
        $dom = new \DOMDocument('1.0');
        @$dom->loadHTMLFile($url);
        $this->results[] = array( //Массив результатов сканирования
            'url' => $url,
            'content' => @$dom->saveHTML()
        );
        var_dump($url);

        $anchors = $dom->getElementsByTagName('a');
        foreach ($anchors as $element) {
            if (!$href = $this->buildUrl($url, $element->getAttribute('href'))) continue;
            $this->_crawl($href);


        }

        return $url;
    }

    private function buildUrl($url, $href)
    { //Построение URL

        $url = trim($url);
        $href = trim($href);
        if (strpos($href, 'http') !== 0) {
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




