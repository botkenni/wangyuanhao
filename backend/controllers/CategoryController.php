<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/21
 * Time: 23:26
 */
namespace backend\controllers;

use backend\controllers\AdminController;
use common\models\Category;
use Yii;
use yii\data\Pagination;

class CategoryController extends AdminController
{
    public function actionIndex()
    {
        $model = Category::find();
        $pagination = new Pagination(['totalCount' => $model->count(), 'pageSize' => 10]);
        $result = $model->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index',['result' => $result, 'pagination' => $pagination]);
    }

    public function actionAdd()
    {
        $model = new Category();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '添加文章分类成功');
            return $this->redirect(['index']);
        }
        return $this->render('add', ['model' => $model]);
    }

    public function actionEdit($id)
    {
        $id = (int)$id;
        $model = Category::findOne($id);
        if ($model) {
            if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', '编辑文章分类成功');
                return $this->redirect(['index']);
            }
            return $this->render('edit', ['model' => $model]);
        }
        return $this->redirect(['index']);
    }

    public function actionDelete()
    {
        $selected = Yii::$app->request->post('selected');
        if (Category::deleteIn($selected)) {
             Yii::$app->session->setFlash('success', '删除文章分类成功');
        } else {
            Yii::$app->session->setFlash('error', '删除文章分类失败');
        }
        return $this->redirect(['index']);
    }
}