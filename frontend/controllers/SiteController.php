<?php
namespace frontend\controllers;

use common\models\ArticleComment;
use Yii;
use yii\filters\PageCache;
use yii\web\Controller;
use frontend\components\CategoryQry;
use frontend\components\ArticleQry;
use yii\data\Pagination;
use frontend\components\ArticleCommentQry;
use frontend\components\SettingQry;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();
        $webSetting = SettingQry::getInstance()->getSetting();

        foreach ($webSetting as $key=>$value) {
            Yii::$app->view->params[$key] = $value;
        }

        //Yii::$app->view->params['aaa'] = '123';
    }

    public function actionIndex($cid = 0)
    {
        $cid = (int) $cid;

        //所有分类
        $categorys = CategoryQry::getInstance()->getCategorys();

        //获取当前筛选分类
        $nowCategory = [];
        if ($cid != 0 && !isset($categorys[$cid])) {
            $cid = 0;
        } else {
            $nowCategory = $categorys[$cid];
        }

        //获取文章列表
        $pagination = new Pagination(['totalCount' => ArticleQry::getInstance()->count($cid), 'pageSize' => 10]);
        $articles = ArticleQry::getInstance()->getArticles($cid, $pagination->offset, $pagination->limit);

        //热门文章
        $hotArticles = ArticleQry::getInstance()->getHotArticles();

        return $this->render('index', ['categorys' => $categorys, 'articles' => $articles, 'pagination' => $pagination , 'nowCategory' => $nowCategory, 'hotArticles' => $hotArticles]);
    }


    public function actionArticle($id = 0)
    {
        $id = (int) $id;
        if ($id > 0 && ($article = ArticleQry::getInstance()->getArticle($id))) {
            //添加浏览次数
            ArticleQry::getInstance()->incrArticleCount($id);
            return $this->render('article', ['article' => $article]);
        }

        return $this->redirect(['site/index']);
    }

    public function actionSearch($search = '')
    {
        if ($search == '' || mb_strlen($search,'utf-8') > 255) {
            return $this->redirect(['site/index']);
        }

         //所有分类
        $categorys = CategoryQry::getInstance()->getCategorys();

        $pagination = new Pagination(['totalCount' => ArticleQry::getInstance()->getLikeArticleCount($search), 'pageSize' => 10]);
        $articles = ArticleQry::getInstance()->getLikeArticles($search, $pagination->offset, $pagination->limit);

        //热门文章
        $hotArticles = ArticleQry::getInstance()->getHotArticles();

        return $this->render('index', ['categorys' => $categorys, 'articles' => $articles, 'pagination' => $pagination , 'nowCategory' => [], 'hotArticles' => $hotArticles , 'search' => $search]);

    }


    /**
     * 点赞处理
    */
    public function actionUp($id = 0)
    {
        $id = (int) $id;
        if ($id > 0 && Yii::$app->request->isAjax) {
            $status = ArticleQry::getInstance()->upArticle($id);
            exit(json_encode($status));
        }
        return $this->redirect(['site/index']);
    }


    /**
     * 提交用户评论
    */
    public function actionRecomment()
    {
        if (Yii::$app->request->isAjax) {
            $data['name'] = Yii::$app->request->post('name', '');
            $data['content'] = Yii::$app->request->post('content', '');
            $data['article_id'] = (int)Yii::$app->request->post('rid', 0);
            $data['pid'] = (int)Yii::$app->request->post('comment_id', 0);

            exit(json_encode(ArticleCommentQry::getInstance()->add($data)));
        }
        return $this->redirect(['site/index']);
    }


    public function actionRecommentList()
    {
        $articleId = (int)Yii::$app->request->get('article_id', 0);

        $count = ArticleCommentQry::getInstance()->count($articleId);
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 6]);
        $data = ArticleCommentQry::getInstance()->articleCommentList($articleId, $pagination->offset, $pagination->limit);

        $pageStr =\yii\widgets\LinkPager::widget([
            'pagination' =>$pagination,
            'options' => [
                'id' => 'yw0',
                'class' => 'yiiPager'
            ]
        ]);

        $pageStr = preg_replace('/href="[^"]+page=(\d+)[^"]+"/', 'onclick="ajaxData(\1);"', $pageStr);
        $pageStr = str_replace('class="active"', 'class="selected"', $pageStr);

        exit(json_encode(['pageStr' => $pageStr, 'count' => $count, 'data' => $data]));
    }

}
