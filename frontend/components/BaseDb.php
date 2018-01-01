<?php
/**
 * YiiBlog
 *
 * @author: Administrator
 * @date: 2016/5/12 23:14
 * @copyright Copyright (c) 2016 xjuke.com
 */
namespace frontend\components;

abstract class BaseDb
{
    protected static $instance;

    public static function getInstance()
    {
        $class = get_called_class();
        if (!isset(self::$instance[$class])) {
            self::$instance[$class] = new $class;
        }
        return self::$instance[$class];
    }
}