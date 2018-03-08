<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * 微信添加form form
 */
class SignupFormByWechat extends Model
{
    public $openid;
    public $nickname;
    public $sex;
    public $language;
    public $city;
    public $province;
    public $country;
    public $headimgurl;
    public $unionid;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['openid', 'trim'],
            ['openid', 'required'],
            ['openid', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],

            ['openid', 'trim'],
            ['nickname', 'trim'],
            ['sex', 'trim'],
            ['language', 'trim'],
            ['city', 'trim'],
            ['province', 'trim'],
            ['country', 'trim'],
            ['headimgurl', 'trim'],
            ['unionid', 'trim'],
//            ['email', 'required'],
//            ['email', 'email'],
//            ['email', 'string', 'max' => 255],
//            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
//
//            ['password', 'required'],
//            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->openid = $this->openid;
        $user->nickname = $this->nickname;
        $user->sex = $this->sex;
        $user->language = $this->language;
        $user->city = $this->city;
        $user->province = $this->province;
        $user->country = $this->country;
        $user->headimgurl = $this->headimgurl;
        $user->unionid = $this->unionid;
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
