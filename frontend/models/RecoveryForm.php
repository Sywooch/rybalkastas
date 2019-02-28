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

use common\models\SCCustomerRegFieldsValues;
use common\models\SCCustomers;
use common\models\User;
use dektrium\user\Finder;
use dektrium\user\Mailer;
use yii\base\Model;
use yii\helpers\BaseInflector;

/**
 * Model for collecting data on password recovery.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RecoveryForm extends Model
{
    const SCENARIO_REQUEST = 'request';
    const SCENARIO_RESET = 'reset';

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * @var Finder
     */
    protected $finder;

    /**
     * @param Mailer $mailer
     * @param Finder $finder
     * @param array  $config
     */
    public function __construct(Mailer $mailer, Finder $finder, $config = [])
    {
        $this->mailer = $mailer;
        $this->finder = $finder;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email'    => \Yii::t('user', 'Email'),
            'password' => \Yii::t('user', 'Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_REQUEST => ['email'],
            self::SCENARIO_RESET => ['password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'emailTrim' => ['email', 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
            'passwordRequired' => ['password', 'required'],
            'passwordLength' => ['password', 'string', 'max' => 72, 'min' => 6],
        ];
    }

    /**
     * Sends recovery message.
     *
     * @return bool
     */
    public function sendRecoveryMessage()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->finder->findUserByEmail($this->email);

        if(empty($user)){
            $findCustomer = SCCustomers::find()->where(['Email'=>$this->email])->orderBy("Login DESC")->one();
            if(!empty($findCustomer)){
                if(!empty($findCustomer->Login)){
                    $transferData['username'] = str_replace("+", "", BaseInflector::transliterate($findCustomer->Login));
                    $transferData['password'] = base64_decode($findCustomer->cust_password);
                } else {
                    $transferData['username'] = str_replace("+", "", BaseInflector::transliterate($findCustomer->Email));
                    $transferData['password'] = uniqid();
                }
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
                $regForm->register($findCustomer);
            }
        }

        $user = $this->finder->findUserByEmail($this->email);
        if(empty($user)){
            \Yii::$app->session->setFlash(
                'info',
                \Yii::t('user', 'Ваша учетная запись содержит неверные данные. Для устранения этой проблемы, свяжитесь с нами по телефону или по электронной почте contacts@rybalkashop.ru')
            );

            return false;
        }

        /** @var Token $token */
        $token = \Yii::createObject([
            'class' => Token::className(),
            'user_id' => $user->id,
            'type' => Token::TYPE_RECOVERY,
        ]);

        if (!$token->save(false)) {
            return false;
        }

        $mail = \Yii::$app->mailer->compose(['html'=>'@frontend/views/mail/recovery'],['user'=>$user, 'token'=>$token])
            ->setFrom(['support@rybalkashop.ru' => 'Rybalkashop.ru Рыболов на "Птичке"']);
        $mail->setTo($this->email);
        $mail->setSubject("Восстановление доступа");
        $mail->send();


        \Yii::$app->session->setFlash(
            'info',
            \Yii::t('user', 'An email has been sent with instructions for resetting your password')
        );

        return true;
    }

    /**
     * Resets user's password.
     *
     * @param Token $token
     *
     * @return bool
     */
    public function resetPassword(Token $token)
    {
        if (!$this->validate() || $token->user === null) {
            return false;
        }

        if ($token->user->resetPassword($this->password)) {
            \Yii::$app->session->setFlash('success', \Yii::t('user', 'Your password has been changed successfully.'));
            $token->delete();
        } else {
            \Yii::$app->session->setFlash(
                'danger',
                \Yii::t('user', 'An error occurred and your password has not been changed. Please try again later.')
            );
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'recovery-form';
    }
}
