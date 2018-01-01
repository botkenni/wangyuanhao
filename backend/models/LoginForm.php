<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/13
 * Time: 22:18
 */
namespace backend\models;

use yii\base\Model;
use common\models\User;
use Yii;
use yii\web\Cookie;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;
    public $remember;

    private $user;
    const BACKEND_ID = 'backend_id';
    const BACKEND_USERNAME = 'backend_username';
    const BACKEND_COOKIE = 'backend_remember';

    public function rules()
    {
        return [
            ['username' , 'validateAccount' , 'skipOnEmpty' => false],
            ['verifyCode' , 'captcha' , 'captchaAction' => 'login/captcha' , 'message' => '验证码错误'],
            [['password' , 'remember'] , 'safe'],
        ];
    }

    /**
     * 验证用户和密码
    */
    public function validateAccount($attribute, $params)
    {
        if(!preg_match('/^\w{2,30}$/' , $this->$attribute)){
            $this->addError($attribute , '账号或密码错误');
        }else if(strlen($this->password) < 6){
            $this->addError($attribute , '账号或密码错误');
        }else{
            $user = User::find()->where(['username' => $this->$attribute , 'status' => 1])->asArray()->one();
            if(!$user || md5($this->password) != $user['password']){
                 $this->addError($attribute , '账号或密码错误');
            }else{
                $this->user = $user;
            }
        }
    }

    public function login()
    {
        if(!$this->user && $this->updateUserStatus()) return false;
        $this->createSession();
        if($this->remember == 1){
            $this->createCookie();
        }
        return true;
    }

    private function createSession()
    {
        //第一步生成session
        $session = Yii::$app->session;
        $session->set(self::BACKEND_ID , $this->user['id']);
        $session->set(self::BACKEND_USERNAME , $this->user['username']);
    }

    private function createCookie()
    {
        $cookie = new Cookie();
        $cookie->name = self::BACKEND_COOKIE;
        $cookie->value = [
            'id' => $this->user['id'],
            'username' => $this->user['username']
        ];
        //cookie保存7天
        $cookie->expire = time() + 60 * 60 * 24 * 7;
        $cookie->httpOnly = true;

        Yii::$app->response->cookies->add($cookie);
    }

    private function updateUserStatus()
    {
        $user = User::findOne($this->user['id']);
        $user->login_update = Yii::$app->request->getUserIP();
        $user->login_date = time();
        return $user->save();
    }

    /**
     * 通过cookie登录
    */
    public function loginByCookie()
    {
        $cookies = Yii::$app->request->cookies;
        if($cookies->has(self::BACKEND_COOKIE))
        {
            $userData = $cookies->getValue(self::BACKEND_COOKIE);
            if(isset($userData['id']) && isset($userData['username'])){
                $this->user = User::find()->where(['username' => $userData['username'] , 'id' => $userData['id'] , 'status' => 1])->asArray()->one();
                if($this->user){
                    $this->createSession();
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * 退出登录
    */
    public static function lagout()
    {
        $session = Yii::$app->session;
        $session->remove(self::BACKEND_ID);
        $session->remove(self::BACKEND_USERNAME);
        $session->destroy();

        $cookies = Yii::$app->request->cookies;
        //可能存在cookie
        if($cookies->has(self::BACKEND_COOKIE))
        {
            $rememberCookie = $cookies->get(self::BACKEND_COOKIE);
            Yii::$app->response->cookies->remove($rememberCookie);
        }
        return true;
    }

}