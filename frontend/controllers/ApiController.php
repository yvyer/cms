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
class ApiController extends BaseAPIController
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

    public function actionLogin()
    {
        $username = \Yii::$app->request->post('username');
        $password = \Yii::$app->request->post('password');

        if (!$username || !$password) {
            return ['success'=>1,'msg'=>'用户名或密码错误!'];
        }

        $model = new LoginForm();
        $ret = $model->load(['LoginForm' => ['username' => $username, 'password' => $password, 'rememberMe' => true]]) && $model->login();

        return $ret ? ['success'=>0,'msg'=>'登录成功!'] : ['success'=>1,'msg'=>'用户名或密码错误!'];
    }

    public function actionInfo()
    {
        $username = \Yii::$app->request->post('username');
        $password = \Yii::$app->request->post('password');

        if (!$username || !$password) {
            return ['success'=>1,'msg'=>'用户名或密码错误!'];
        }

        $model = new LoginForm();
        $ret = $model->load(['LoginForm' => ['username' => $username, 'password' => $password, 'rememberMe' => true]]) && $model->login();

        return $ret ? ['success'=>0,'msg'=>'登录成功!'] : ['success'=>1,'msg'=>'用户名或密码错误!'];
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();;
    }
}
