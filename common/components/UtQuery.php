<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 25.06.2018
 * Time: 13:46
 */


namespace common\components;


use yii\helpers\Json;

class UtQuery
{
    public static function runQuery($string, $from = 1, $to = 9999999)
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        ini_set('default_socket_timeout', 1220);

        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';

        $client = new \SoapClient($url,
            [
                'login'=>'siteabserver',
                'password'=>'revresbaetis',
                'trace' =>true,
                'cache_wsdl' => 0,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
                'location' => str_replace('?wsdl', '', $url)
            ]
        );
        $res = $client->query(['string'=>$string, 'from_i'=>$from, 'to_i'=>$to]);
        $obj = $res->return;
        $ar = Json::decode($obj);
        $return = [];
        foreach($ar as $dataAr){
            $return[] = $dataAr;
        }


        return $return;
    }
}