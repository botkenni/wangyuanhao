<?php
/**
 * YiiBlog
 *
 * @author: Administrator
 * @date: 2016/5/12 23:16
 * @copyright Copyright (c) 2016 xjuke.com
 */
namespace frontend\components;

use Yii;
use frontend\components\BaseDb;
use common\models\Article;
use yii\web\Cookie;

class ArticleQry extends BaseDb
{

    /**
     * 获取文章的个数
     *
     * @param int $cid 文章分类
    */
    public function count($cid = 0)
    {
        //预留给cid
        $where = [];
        if ($cid > 0) {
            $where['cid'] = (int)$cid;
        }
        return Article::find()->where(array_merge(['status' => 1], $where))->count();
    }


    /**
     * 读取文章数据
     *
     * @param int $cid 文章分类
     * @param int $offset 偏移量
     * @param int $limit 每页个数
    */
    public function getArticles($cid = 0, $offset = 0, $limit = 10)
    {
        $where = [];
        if ($cid > 0) {
            $where['cid'] = (int)$cid;
        }
        return Article::find()->select('id, cid, title, update_date, author, count, description')->where(array_merge(['status' => 1], $where))->offset($offset)->limit($limit)->asArray()->all();
    }


    /**
     * 获取热门文章
     *
     * @param int $limit 获取条数，默认10条
    */
    public function getHotArticles($limit = 10)
    {
        return Article::find()->select('id, title')->where(['status' => 1])->orderBy('count DESC')->limit($limit)->asArray()->all();
    }


    /**
     * 获取模糊查询文章的个数
     *
     * @param string $title 模糊查询标题
    */
    public function getLikeArticleCount($title)
    {
        return Article::find()->where(['and', ['status' => 1], ['like', 'title', $title]])->count();
    }


    /**
     * 获取模糊查询文章
     *
     * @param string $title 模糊查询标题
    */
    public function getLikeArticles($title, $offset = 0, $limit = 10)
    {
        return Article::find()->select('id, cid, title, update_date, author, count, description')->where(['and', ['status' => 1], ['like', 'title', $title]])->offset($offset)->limit($limit)->asArray()->all();
    }

    /**
     * 根据id获取we文章详情
     *
     * @param int $id 文章id
    */
    public function getArticle($id)
    {
        $sql = 'SELECT a.id, a.title, a.description, a.content, a.image, a.author, a.count, a.up, a.update_date, a.cid, c.name as cname FROM {{%article}} a
                LEFT JOIN {{%category}} c ON a.cid=c.id
                WHERE a.id=:id AND a.status=1 LIMIT 1';
        return Article::findBySql($sql,[':id' => $id])->asArray()->one();
    }


    /**
     * 添加文章的浏览次数 , 每次添加1
     *
     * @param int $id 文章id
    */
    public function incrArticleCount($id)
    {
        $sql = 'UPDATE {{%article}} SET count=count+1 WHERE id=:id';
        return Yii::$app->db->createCommand($sql)->bindValue(':id', $id)->execute();
    }

    /**
     * 文章点赞
     *
     * @param int $id 文章id
    */
    public function upArticle($id)
    {
        $rest = ['status' => false , 'msg' => '非法操作'];
        //判断文章是否合法
        if (Article::find()->where(['id' => $id, 'status' => 1])->count() > 0) {
            $key = md5('article_up_'.Yii::$app->request->userIP.$id);
            if (!Yii::$app->request->cookies->has($key)) { //一篇文章一个人只能点赞一次 , 生cookie来控制
                //生成cookie
                $cookie = new Cookie();
                $cookie->name = $key;
                $cookie->value = true;
                $cookie->expire = time() + 86400; //保存一天
                $cookie->httpOnly = true;

                Yii::$app->response->cookies->add($cookie);
                Yii::$app->response->send();
                //添加点赞个数
                $sql = 'UPDATE {{%article}} SET up=up+1 WHERE id=:id';
                if (Yii::$app->db->createCommand($sql)->bindValue(':id', $id)->execute()) {
                     $rest = ['status' => true , 'msg' => '谢谢您的支持'];
                }else {
                    $rest['msg'] = '操作异常，请稍后再试';
                }
            } else {
                $rest['msg'] = '您今天已经对该文章点过赞了';
            }
        }
        return $rest;
    }

    /**
     * 判断文章是否存在
     *
     * @param int $id 文章id
    */
    public function articleExists($id)
    {
        return (Article::find()->where(['id' => $id, 'status' =>1])->count() > 0);
    }
}