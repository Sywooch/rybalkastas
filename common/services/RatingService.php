<?php

namespace common\services;

use frontend\models\ReviewForm;
use Yii;
use common\models\SCShopRatings;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class RatingService
 * @package backend\services
 *
 * @author Dmitriy Mosolov
 * @version 1.0
 */
class RatingService
{
    public static function send(ReviewForm $form, $postData)
    {
        if ($form->load($postData) && !Yii::$app->user->isGuest) {
            if (empty($form->stars)) {
                return Yii::$app->controller->redirect(['reviews']);
            }

            $model = new SCShopRatings;

            $model->rating        = $form->stars;
            $model->user_id       = Yii::$app->user->identity->customer->customerID;
            $model->content_text  = $form->text;
            $model->approved      = 0;
            $model->hidden        = 0;
            $model->response_text = '';
            $model->response_date = '';

            if ($model->save()) {
                Yii::$app->session->setFlash('notify', [
                    'msg'  => 'Отзыв успешно отправлен!',
                    'icon' => 'fa-commenting-o'
                ]);
            }
        }

        return self::toFrontendRatingIndexPage();
    }

    public static function reply(int $id, string $responseText)
    {
        $rating = self::findShopRating($id);

        if ($rating) {
            $rating->updateAttributes([
                'response_text' => $responseText,
            ]);

            Yii::$app->session->setFlash('success', 'Ответ сохранен');
        }

        return self::toAdminRatingIndexPage();
    }

    public static function ratingConfirmed(int $id, int $approved) : Response
    {
        $rating = self::findShopRating($id);

        if ($rating) {
            $rating->updateAttributes([
                'approved' => $approved
            ]);
        }

        return self::toAdminRatingIndexPage();
    }

    public static function ratingHide(int $id, int $hidden) : Response
    {
        $rating = self::findShopRating($id);

        if ($rating) {
            $rating->updateAttributes([
                'hidden' => $hidden
            ]);
        }

        return self::toAdminRatingIndexPage();
    }

    public static function formValidation(ReviewForm $form, $postData) : array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $form->load($postData);

        return ActiveForm::validate($form);
    }

    //================================================================================================================

    private static function findShopRating($id) : SCShopRatings
    {
        return SCShopRatings::findOne($id);
    }

    private static function toFrontendRatingIndexPage()
    {
        return Yii::$app->controller->redirect([
            '/review/index'
        ]);
    }

    private static function toAdminRatingIndexPage()
    {
        return Yii::$app->controller->redirect([
            '/ratings/index'
        ]);
    }
}
