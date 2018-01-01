<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/28
 * Time: 23:13
 */
namespace backend\controllers;

use Yii;
use common\models\User;
use yii\data\Pagination;

class UserController extends AdminController
{
    public $layout = 'empty';
    public function actionIndex()
    {
        $model = User::find();
        $pagination = new Pagination(['totalCount' => $model->count() , 'pageSize' => 10]);
        $result = $model->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index' , ['result' => $result , 'pagination' => $pagination]);
    }


    public function actionAdd()
    {
        $model = new User();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->session->setFlash('success' , '添加用户成功');
            return $this->redirect(['index']);
        }
        return $this->render('add' , ['model' => $model]);
    }


    public function actionEdit()
    {
        $id = Yii::$app->request->get('id' , 0);
        $model = User::findOne($id);
        if(!$model) return $this->redirect(['index']);
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->session->setFlash('success' , '编辑用户成功');
            return $this->redirect(['index']);
        }
        $model->password = '';
        return $this->render('edit' , ['model' => $model]);
    }


    public function actionDelete()
    {
        $selected = Yii::$app->request->post('selected' , []);
        if(User::deleteIn($selected)){
            Yii::$app->session->setFlash('success' , '删除用户成功');
        }else{
            Yii::$app->session->setFlash('error' , '删除用户失败');
        }
        return $this->redirect(['index']);
    }
}