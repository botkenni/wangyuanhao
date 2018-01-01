<?php
/**
 * YiiBlog
 *
 * @author: Administrator
 * @date: 2016/5/23 22:15
 * @copyright Copyright (c) 2016 xjuke.com
 */
namespace common\models;

use yii\db\ActiveRecord;

class ArticleComment extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%article_comment}}';
    }

    public function rules()
    {
        return [
            [['name', 'content', 'article_id', 'pid'], 'safe']
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->date = time();
            return true;
        }
        return false;
    }
}