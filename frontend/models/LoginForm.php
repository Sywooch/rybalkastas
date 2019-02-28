<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace frontend\models;

use common\models\Profile;
use common\models\SCCustomerRegFieldsValues;
use common\models\SCCustomers;
use common\models\SCOrders;
use common\models\User;
use dektrium\user\Finder;
use dektrium\user\helpers\Password;
use dektrium\user\models\RegistrationForm;
use dektrium\user\traits\ModuleTrait;
use dvizh\cart\models\Cart;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseInflector;
use yii\helpers\Html;
use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

/**
 * LoginForm get user's login and password, validates them and logs the user in. If user has been blocked, it adds
 * an error to login form.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class LoginForm extends Model
{
    use ModuleTrait;

    /** @var string User's email or username */
    public $login;

    /** @var string User's plain password */
    public $password;

    /** @var string Whether to remember the user */
    public $rememberMe = false;

    /** @var \dektrium\user\models\User */
    protected $user;

    /** @var Finder */
    protected $finder;

    /**
     * @param Finder $finder
     * @param array  $config
     */
    public function __construct(Finder $finder, $config = [])
    {
        $this->finder = $finder;
        parent::__construct($config);
    }

    /**
     * Gets all users to generate the dropdown list when in debug mode.
     *
     * @return string
     */
    public static function loginList()
    {
        return ArrayHelper::map(User::find()->where(['blocked_at' => null])->all(), 'username', function ($user) {
            return sprintf('%s (%s)', Html::encode($user->username), Html::encode($user->email));
        });
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'login'      => 'Логин или Email',
            'password'   => Yii::t('user', 'Password'),
            'rememberMe' => Yii::t('user', 'Remember me next time'),
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        $rules = [
            'loginTrim' => ['login', 'trim'],
            'requiredFields' => [['login'], 'required'],
            'confirmationValidate' => [
                'login',
                function ($attribute) {
                    if ($this->user !== null) {
                        $confirmationRequired = $this->module->enableConfirmation
                            && !$this->module->enableUnconfirmedLogin;
                        if ($confirmationRequired && !$this->user->getIsConfirmed()) {
                            $this->addError($attribute, Yii::t('user', 'You need to confirm your email address'));
                        }
                        if ($this->user->getIsBlocked()) {
                            $this->addError($attribute, Yii::t('user', 'Your account has been blocked'));
                        }
                    }
                }
            ],
            'rememberMe' => ['rememberMe', 'boolean'],
        ];

        if (!$this->module->debug) {
            $rules = array_merge($rules, [
                'requiredFields' => [['login', 'password'], 'required'],
                'passwordValidate' => [
                    'password',
                    function ($attribute) {
                        if ($this->user === null || !Password::validate($this->password, $this->user->password_hash)) {
                            $findCustomer = SCCustomers::find()->where(['Login'=>$this->login])->andWhere("cust_password <> ''")->one();
                            if(!empty($findCustomer)){
                                if(!$findCustomer->cust_password == base64_encode($this->password)){
                                    $this->addError($attribute, Yii::t('user', 'Invalid login or password'));
                                }
                            } else {
                                $this->addError($attribute, Yii::t('user', 'Invalid login or password'));
                            }
                        }
                    }
                ]
            ]);
        }

        return $rules;
    }

    /**
     * Validates if the hash of the given password is identical to the saved hash in the database.
     * It will always succeed if the module is in DEBUG mode.
     *
     * @return void
     */
    public function validatePassword($attribute, $params)
    {
        if ($this->user === null || !Password::validate($this->password, $this->user->password_hash)){
            $findCustomer = SCCustomers::find()->where(['Login'=>$this->login])->andWhere("cust_password <> ''")->one();
            if(!empty($findCustomer)){
                if(!$findCustomer->cust_password == base64_encode($this->password)){
                    $this->addError($attribute, Yii::t('user', 'Invalid login or password'));
                }
            } else {
                $this->addError($attribute, Yii::t('user', 'Invalid login or password'));
            }
        }

    }

    /**
     * Validates form and logs the user in.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {

        $findUser = User::find()->where(['username'=>$this->login])->orWhere(['email'=>$this->login])->one();
        //$findUserD = User::find()->where(['username'=>$this->login])->orWhere(['email'=>$this->login])->one();

        if(!empty($findUser) && $this->login == $findUser->email){
            $this->login = $findUser->email;
        }



        $cart = Yii::$app->cart->cart;

        $oldAccount = false;



        if(empty($findUser)){
            $findCustomer = SCCustomers::find()->where(['Login'=>$this->login])->orWhere(['Email'=>$this->login])->andWhere("cust_password <> ''")->one();
            if(!empty($findCustomer)){
                //$lol = ['first_name', 'last_name','phone', 'city','street','house','zip'];

                $transferData['username'] = str_replace("+", "", BaseInflector::transliterate($findCustomer->Login));
                $transferData['password'] = base64_decode($findCustomer->cust_password);
                $transferData['email'] = $findCustomer->Email;
                $transferData['first_name'] = $findCustomer->first_name;
                $transferData['last_name'] = $findCustomer->last_name;
                $transferData['accept_policy'] = 1;

                $unique = false;
                $un = $transferData['username'];

                while (!$unique){
                    if(!empty(User::find()->where(['username'=>$un])->all() )){
                        $un .= '1';
                        $unique = false;
                    } else {
                        $transferData['username'] = $un;
                        $unique = true;
                    }
                }

                $fval = SCCustomerRegFieldsValues::find()->where(['customerID'=>$findCustomer->customerID])->andWhere(['reg_field_id'=>1])->one();
                if(!empty($fval)){
                    $phone = $fval->reg_field_value;
                } else {
                    $phone = "0000000000";
                }
                $transferData['phone'] = $phone;
                $findCustomer->phone = $phone;
                $findCustomer->save();


                $regForm = new \frontend\models\RegistrationForm();
                $regForm->attributes = $transferData;
                if(!$regForm->register($findCustomer)){
                    if($_SERVER['REMOTE_ADDR'] == "176.107.242.44"){
                        $this->addError("password", $transferData['username']);
                    } else {
                        $this->addError("password", Yii::t('user', 'Invalid login or password'));
                    }
                    return false;
                }
                $oldAccount = true;


            } else {
                //\Yii::$app->bot->sendMessage(-14068578, "$this->login не найден");

            }
        }



        if($_SERVER['REMOTE_ADDR'] == "176.107.242.44"){
           /*$findUser->password_hash = Password::hash($this->password);
           $findUser->save();*/
        }




        if (
            $this->validate() && !empty($this->user) &&
            Password::validate(
                $this->password,
                    $this->user->password_hash)) {
            $this->user->updateAttributes(['last_login_at' => time()]);
            if($oldAccount == true){
                $findCustomer->user_id = $this->user->getId();
                $findCustomer->save();
                $profile = Profile::findOne($this->user->getId());
                $profile->name = $findCustomer->first_name.' '.$findCustomer->last_name;
                $profile->save();
            }


            /*$cart->user_id = $this->user->getId();
            $cart->tmp_user_id = null;
            $oldCart = Cart::find()->where(['user_id'=>$this->user->getId()])->one();
            if(!empty($oldCart)){
                $oldCart->delete();
            }
            $cart->save();*/


            return Yii::$app->getUser()->login($this->user, $this->rememberMe ? $this->module->rememberFor : 0);
        } else {
            if(empty($this->user) && $_SERVER['REMOTE_ADDR'] == "176.107.242.44"){
                $this->user = $findUser;
                //$this->validate();
                \Yii::$app->bot->sendMessage(-14068578, Json::encode($this->user));

            }

            $this->addError("password", Yii::t('user', 'Invalid login or password'));
        }



        return false;
    }


    /** @inheritdoc */
    public function formName()
    {
        return 'login-form';
    }

    /** @inheritdoc */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->user = User::find()->where(['username'=>trim($this->login)])->orWhere(['email'=>trim($this->login)])->one();

            return true;
        } else {
            return false;
        }
    }
}
