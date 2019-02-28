<?php

namespace common\models\ut;

use common\models\SCProducts;
use Yii;
use yii\base\Model;


class Nomenclature
{
    function __construct($json)
    {
        foreach ($json as $k=>$v){
            $this->$k = $v;
        }
    }

    public function __get($name)
    {
        return $this->{"get".$name}();
    }

    public function getIsLoaded()
    {
        $model = SCProducts::find()->where(['product_code'=>$this->code])->one();
        if(empty($model))return 0;
        return 1;
    }

    public function getIsFolder()
    {
        if($this->folder == 1)return true;
        return false;
    }





    public function getChildren()
    {

    }

    public static function findByCode($code){
        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
        //echo file_get_contents($url);

        $client = new \SoapClient($url,
            [
                'login'=>'siteabserver',
                'password'=>'revresbaetis'
            ]
        );
        $ar = $client->loadProduct(['code'=>$code, 'refresh'=>1]);
        $ars = json_decode($ar->return);
        $element = new Nomenclature($ars);
        unset($client);
        return $element;
    }



}
