<?php
/**
 * YiiBlog
 *
 * @author: Administrator
 * @date: 2016/5/23 22:17
 * @copyright Copyright (c) 2016 xjuke.com
 */
namespace frontend\components;

use common\models\ArticleComment;

class ArticleCommentQry extends BaseDb
{

    public function add($data)
    {
        $ret = ['status' => 0, 'msg' => '非法操作'];
        //先判断文章是否存在
        if (!ArticleQry::getInstance()->articleExists($data['article_id'])) { //判断文章是否存在
            //return $ret;
        } elseif (empty($data['name']) || mb_strlen($data['name'], 'utf-8') > 20) {
            $ret['msg'] = '名称不能为空并且必须在20位以内';
        } elseif (empty($data['content']) || mb_strlen($data['content'], 'utf-8') > 200) {
            $ret['msg'] = '评论内容不能为空并且不能大于200位';
        } elseif ($data['pid'] !=0 && !$this->commentExists($data['article_id'], $data['pid'])){ //pid不等于0的时候，就是子评论
            $ret['msg'] = '您回复的评论并不存在';
        } else {
            $comment = new ArticleComment();
            $comment->setAttributes($data);
            if ($comment->save()) {
                $ret = ['status' => 1, 'msg' => '谢谢您的评论'];
            } else {
                $ret['msg'] = '评论出错，请联系管理员';
            }
        }
        return $ret;
    }

    /**
     * 获取主评论的个数
     *
     * @param int $id 文章的id
    */
    public function count($id)
    {
        return ArticleComment::find()->where(['article_id' => $id, 'pid' => 0, 'status' => 1])->count();
    }


    /**
     * 获取文章评论列表
     *
     * @param int $id 文章的id
     * @param int $offset 偏移量
     * @param int $limit 每页获取的个数
    */
    public function articleCommentList($id, $offset = 0, $limit =10)
    {
        $result = [];
        $data = ArticleComment::find()->select('id, name, content, date')->where(['article_id' => $id, 'pid' => 0, 'status' => 1])->offset($offset)->limit($limit)->asArray()->all();
        $commentIds = [];
        foreach ($data as $k=>$v) {
            $result[$v['id']]  = $v;
            $result[$v['id']]['date'] = date('Y-m-d H:i:s', $v['date']);
            $result[$v['id']]['child']= [];
            $commentIds[] = $v['id'];
        }

        $childComments = ArticleComment::find()->select('id, pid, name, content, date')->where(['and', ['article_id' => $id, 'status' => 1] , ['in', 'pid' , $commentIds]])->asArray()->all();

        foreach ($childComments as $v) {
            $v['id'] = $v['pid'];
            $v['date'] = date('Y-m-d H:i:s', $v['date']);
            $result[$v['pid']]['child'][] = $v;
        }

        return $result;
    }


    /**
     * 判断评论是否存在
     *
     * @param int $articleId 文章的id
     * @param int $id 评论的id
    */
    public function commentExists($articleId, $id)
    {
        return (ArticleComment::find()->where(['article_id' => $articleId, 'id' => $id, 'status' => 1])->count() > 0);
    }

}