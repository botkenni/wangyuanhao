<?php
namespace backend\controllers;

use Yii;

/**
 * Site controller
 */
class SiteController extends AdminController
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }

    public function actionMain()
    {
        echo 'main';
    }

    /**
     * 注销
    */
    public function actionLogout()
    {
        \backend\models\LoginForm::lagout();
        return $this->redirect(['login/index']);
    }

}
