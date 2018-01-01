<?php
/**
 * YiiBlog
 *
 * @author: Administrator
 * @date: 2016/5/12 23:18
 * @copyright Copyright (c) 2016 xjuke.com
 */
namespace frontend\components;

use frontend\components\BaseDb;
use common\models\Category;

class CategoryQry extends BaseDb
{
    public function getCategorys()
    {
        $result = [
            0 => [
                'id' => 0,
                'name' => '全部',
                'labelName' => '全部',
                'pid' => -1
            ]
        ];
        $categorys = Category::getAllCategorys();

        foreach ($categorys as $category) {
            $result[$category['id']] = [
                'id' => $category['id'],
                'name' => $category['name'],
                'labelName' => $category['name'],
                'pid' => $category['pid']
            ];

            foreach ($category['child'] as $cate) {
                $result[$cate['id']] = [
                    'id' => $cate['id'],
                    'name' => $cate['name'],
                    'labelName' => '&nbsp;&nbsp;&nbsp;&nbsp;' . $cate['name'],
                    'pid' => $cate['pid']
                ];
            }
        }

        return $result;
    }
}