<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/3
 * Time: 22:31
 */
namespace backend\controllers;

use Yii;
use common\models\Article;
use backend\controllers\AdminController;
use Imagine\Image\ManipulatorInterface;
use xj\uploadify\UploadAction;
use yii\imagine\Image;

class ArticleController extends AdminController
{
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    //生成图片缩略图， 然后会存储的图片
                    //a.jpg -> a.jpg , images/a.jpg -> images/a.jpg
                    //a-100x100.jpg

                    //D://www/xxx/web/
                    $thumbnailDir = Yii::getAlias('@webroot/upload/thumbnail/');
                    if (!is_dir($thumbnailDir)) {
                        @mkdir($thumbnailDir);
                    }

                    $fileImage = $action->getFilename();
                    $suffixPoint = strrpos($fileImage, '.');
                    $thumnailName = substr($fileImage,0,$suffixPoint) . '-100x100' . substr($fileImage,$suffixPoint);

                    Image::thumbnail($action->getSavePath(), 100, 100, \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET)->save($thumbnailDir.$thumnailName, ['quality' => 100]);

                    //http://localhost:8080/YiiBlog/backend/web/
                    $action->output['thumbnail'] = Yii::getAlias('@web/upload/thumbnail/').$thumnailName;
                    $action->output['image'] = $fileImage;

                },
            ],'upload' => [
                'class' => 'cliff363825\kindeditor\KindEditorUploadAction',
                'savePath' => '@webroot/upload',
                'saveUrl' => '@web/upload',
                'maxSize' => 2097152,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', ['result' => [], 'pagination' => new \yii\data\Pagination()]);
    }

    public function actionAdd()
    {
        $model = new Article();
        if (Yii::$app->request->isPost ) {
            print_r(Yii::$app->request->post());
            exit();
        }

        return $this->render('add', ['model' => $model]);
    }

}