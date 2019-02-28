<?php

namespace backend\modules\ut\controllers;

use common\models\SCCategories;
use common\models\SCCertificates;
use common\models\SCProducts;
use common\models\ut\Nomenclature;
use yii\web\Controller;
use yii\helpers\Json;
use yii\web\Session;

/**
 * Default controller for the `ut` module
 */
class CertificatesController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
        //echo file_get_contents($url);

        $client = new \SoapClient($url,
            [
                'login'=>'siteabserver',
                'password'=>'revresbaetis'
            ]
        );
        $ar = $client->getCertificates();
        $ars = json_decode($ar->return);

        foreach($ars as $a){
            $m = SCCertificates::find()->where(['certificateNumber'=>$a->number])->one();
            if(empty($m)){
                $m = new SCCertificates;
                $m->certificateNumber = $a->number;

                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 12; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }

                $m->certificateCode = $randomString;
                $m->certificateRating = $a->rating;
                $m->certificateUsed = 0;
                $m->save();
            }
        }

        return $this->render('index', ['certs'=>$ars]);
    }

    public function actionUploadCert()
    {
        $data = $_POST;
        $model = SCCertificates::find()->where(['certificateNumber'=>$data['number']])->one();
        $isNew = 0;
        if(empty($model)){
            $model = new SCCertificates();
            $model->certificateNumber = $data['number'];
            $model->certificateRating = $data['rating'];
            $isNew = 1;
        }
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 12; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $model->certificateCode = $randomString;
        $model->certificateUsed = 0;
        $model->save();

        $dataPost = [];
        $dataPost['number'] = $model->certificateNumber;
        $dataPost['rating'] = $model->certificateRating;
        $dataPost['isNew'] = $isNew;
        $dataPost['charCode'] = $data['charCode'];
        $dataPost['nomCode'] = $data['nomCode'];

        $jsonPost = Json::encode($dataPost);



        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
        $client = new \SoapClient($url,
            [
                'login'=>'siteabserver',
                'password'=>'revresbaetis'
            ]
        );
        $ar = $client->uploadCertificate(['data'=>$jsonPost]);
    }


    function normalizeJson()
    {
        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
        //echo file_get_contents($url);

        $client = new \SoapClient($url,
            [
                'login'=>'siteabserver',
                'password'=>'revresbaetis'
            ]
        );
        $ar = $client->getCertificates();
        $ars = json_decode($ar->return);
        $serial = [];

        foreach ($ars as $a){
            $element = new Nomenclature($a);
            $serial[] = $element;
        }

        return $serial;
    }
}
