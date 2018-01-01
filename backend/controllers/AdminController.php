<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/14
 * Time: 23:35
 */
namespace backend\controllers;
use Yii;

class AdminController extends CommonController
{
    public $layout = 'empty';

    public function init()
    {
        parent::init();
        if(!$this->userId){
            return Yii::$app->response->redirect(['login/index']);
        }
    }
}