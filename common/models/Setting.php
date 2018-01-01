<?php
/**
 * YiiBlog
 *
 * @author: Administrator
 * @date: 2016/5/30 21:22
 * @copyright Copyright (c) 2016 xjuke.com
 */
namespace common\models;

use yii\db\ActiveRecord;

class Setting extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%setting}}';
    }

    public function rules()
    {
        return [
            [['name', 'keyword', 'description', 'copyright'], 'required', 'message' => '不能为空'],
            ['name', 'string', 'max' => '100', 'tooLong' => '网站名称不能大于100位'],
            [['keyword', 'description', 'copyright'], 'string', 'max' => '255', 'tooLong' => '长度不能大于255位'],
        ];
    }
}