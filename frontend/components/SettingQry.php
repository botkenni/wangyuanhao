<?php
/**
 * YiiBlog
 *
 * @author: Administrator
 * @date: 2016/5/30 21:35
 * @copyright Copyright (c) 2016 xjuke.com
 */
namespace frontend\components;

use Yii;
use common\models\Setting;

class SettingQry extends BaseDb
{
    public function getSetting()
    {
        $key = 'webSetting';
        $webSetting = Yii::$app->cache->get($key);
        if (!$webSetting) {
            $webSetting = Setting::find()->where(['id' => 1])->asArray()->one();
            Yii::$app->cache->set($key, $webSetting, 300); // 缓存5分钟
        }
        return $webSetting;
    }
}