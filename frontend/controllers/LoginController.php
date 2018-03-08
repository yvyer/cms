<?php
namespace frontend\controllers;

use common\components\Curl;
use common\models\User;
use EasyWeChat\Foundation\Application;
use frontend\models\SignupFormByWechat;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use common\models\LoginForm;

class LoginController extends BaseAPIController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['http://qingtingtui.com'],
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

    public function actionLoginbythirdparty()
    {
        $request_body = file_get_contents('php://input');
        $code = json_decode($request_body, true);
        $code = isset($code['code']) ? $code['code'] : '';
        if (!$code)  {
            return ['success'=>1,'msg'=>'code错误!'];
        }

        //通过code获取access_token
        //{
        //    "access_token":"ACCESS_TOKEN",
        //    "expires_in":7200,
        //    "refresh_token":"REFRESH_TOKEN",
        //    "openid":"OPENID",
        //    "scope":"SCOPE"
        //}
        $curl = new Curl();
        $c2a_response = $curl->setGetParams([
            'appid' => 'xxx',
            'secret' => 'xxx',
            'code' => $code,
            'grant_type' => 'authorization_code'
        ])->get('https://api.weixin.qq.com/sns/oauth2/access_token');
        $c2a_response_arr = json_decode($c2a_response, true);
        $access_token = isset($c2a_response_arr['access_token']) ? $c2a_response_arr['access_token'] : '';
        $openid = isset($c2a_response_arr['openid']) ? $c2a_response_arr['openid'] : '';
        if (!$access_token || !$openid) {
            return ['success'=>1,'msg'=>'获取access_token错误!'];
        }

        $user = User::findIdentityByWechat($openid);
        if ($user) {
            return ['success'=>0,'msg'=>'', 'data' => ['token' => User::generateToken($user['auth_key'])]];
        }

        //获取用户个人信息（UnionID机制）
        //{
        //    "openid":"OPENID",
        //    "nickname":"NICKNAME",
        //    "sex":1,
        //    "province":"PROVINCE",
        //    "city":"CITY",
        //    "country":"COUNTRY",
        //    "headimgurl": "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
        //    "privilege":[
        //        "PRIVILEGE1",
        //        "PRIVILEGE2"
        //    ],
        //    "unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL"
        //}
        $curl2 = new Curl();
        $a2u_response = $curl2->setGetParams([
            'access_token' => $access_token,
            'openid' => $openid
        ])->get('https://api.weixin.qq.com/sns/userinfo');
        $user_info = json_decode($a2u_response, true);
        if (!$user_info) {
            return ['success'=>1,'msg'=>'获取用户信息错误!'];
        }
        unset($user_info['privilege']);
        $model = new SignupFormByWechat();
        if ($model->load(['SignupFormByWechat' => $user_info])) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return ['success'=>0,'msg'=>'', 'data' => ['token' => User::generateToken($user['auth_key'])]];
                }
            }
        }
        return ['success'=>1,'msg'=>'注册用户失败!'];
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();;
    }
}
