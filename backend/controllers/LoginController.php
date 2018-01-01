<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/13
 * Time: 22:11
 */
namespace backend\controllers;

use yii\debug\models\search\Log;
use backend\models\LoginForm;
use Yii;

class LoginController extends CommonController
{
    public function init()
    {
        parent::init();
        //判断用户是否登录
        if($this->userId){
            return Yii::$app->response->redirect(['site/index']);
        }
    }

    public function actions()
    {
       return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 4,
                'minLength' => 4,
                'width' => 80,
                'height' => 40
            ]
       ];
    }

    public function actionIndex()
    {
        $model = new LoginForm();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate() && $model->login()){
            return $this->redirect(['site/index']);
        }
        return $this->renderPartial('index' , ['model' => $model]);
    }
}