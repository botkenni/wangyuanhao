<?php
namespace frontend\controllers;

use yii\web\Controller;

class WellKnownController extends Controller
{
    public function actionAcmeChallenge()
    {

        return $this->render('acme-challenge');
    }
}
