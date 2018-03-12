<?php
namespace frontend\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use common\models\LoginForm;

/**
 * UserController
 */
class UserController extends BaseAPIController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        if (Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
            $behaviors['authenticator'] = [
                'class' => HttpBearerAuth::className(),
            ];
        }

        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['http://localhost:9528','http://qingtingtui.com'],
                    'Access-Control-Request-Method' => ['GET', 'HEAD', 'OPTIONS'],
                ],
            ],
        ], $behaviors);
    }

    public function actionInfo()
    {
        $user = Yii::$app->user->identity;
        return [
            'role' => $user->status,
            'name' => $user->nickname,
            'avatar' => $user->headimgurl,
            'introduction' => $user->nickname,
        ];
    }
}
