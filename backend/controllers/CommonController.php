<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/14
 * Time: 23:22
 */
namespace backend\controllers;

use yii\web\Controller;
use Yii;
use backend\models\LoginForm;

class CommonController extends Controller
{
    public $userId;
    public $userName;

    public function init()
    {
        parent::init();
        //第一步获取session是否存在
        if(!$this->getUserSession()){
            //如果session不存在的话 , 我们判断cookie是否存在
            //有的话通过cookie生成session
            $loginForm = new LoginForm();
            $loginForm->loginByCookie();
            $this->getUserSession();
        }

        $this->userId = Yii::$app->session->get(LoginForm::BACKEND_ID);
        $this->userName = Yii::$app->session->get(LoginForm::BACKEND_USERNAME);
    }


    /**
     * 读取session并赋值给user
    */
    private function getUserSession()
    {
        $session = Yii::$app->session;
        $this->userId = $session->get(LoginForm::BACKEND_ID);
        $this->userName = $session->get(LoginForm::BACKEND_USERNAME);
        return $this->userId;
    }
}