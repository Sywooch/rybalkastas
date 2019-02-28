<?php
namespace frontend\controllers;

use Yii;
use frontend\models\ContactForm;
use yii\db\IntegrityException;
use yii\web\Controller;
use frontend\models\LoginForm;
use yii\authclient\AuthAction;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;

/**
 * Site controller
 */
class AbsenceController extends Controller
{

    /**
     * Event is triggered before logging user in.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_BEFORE_LOGIN = 'beforeLogin';

    /**
     * Event is triggered after logging user in.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_AFTER_LOGIN = 'afterLogin';

    /**
     * Event is triggered before logging user out.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_LOGOUT = 'beforeLogout';

    /**
     * Event is triggered after logging user out.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_LOGOUT = 'afterLogout';

    /**
     * Event is triggered before authenticating user via social network.
     * Triggered with \dektrium\user\events\AuthEvent.
     */
    const EVENT_BEFORE_AUTHENTICATE = 'beforeAuthenticate';

    /**
     * Event is triggered after authenticating user via social network.
     * Triggered with \dektrium\user\events\AuthEvent.
     */
    const EVENT_AFTER_AUTHENTICATE = 'afterAuthenticate';

    /**
     * Event is triggered before connecting social network account to user.
     * Triggered with \dektrium\user\events\AuthEvent.
     */
    const EVENT_BEFORE_CONNECT = 'beforeConnect';

    /**
     * Event is triggered before connecting social network account to user.
     * Triggered with \dektrium\user\events\AuthEvent.
     */
    const EVENT_AFTER_CONNECT = 'afterConnect';

    use AjaxValidationTrait;
    use EventTrait;

    public $layout = 'absence';
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'auth' => [
                'class' => AuthAction::className(),
                // if user is not logged in, will try to log him in, otherwise
                // will try to connect social account to user.
                'successCallback' => \Yii::$app->user->isGuest
                    ? [$this, 'authenticate']
                    : [$this, 'connect'],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = \Yii::createObject(LoginForm::className());

        $event = $this->getFormEvent($model);

        //$this->performAjaxValidation($model);

        //$this->trigger(self::EVENT_BEFORE_LOGIN, $event);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);

            return $this->goBack();
        }

        return $this->render('index', ['model' => $model]);
    }

}