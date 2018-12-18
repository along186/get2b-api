<?php

namespace App\Bll;


use App\Helper\ArrayHelp;

class BaseBll
{
    protected static $instance = null;

    /**
     * 单例
     * @return null|static
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof static) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * 对象转数组
     * @param $obj
     * @return array
     */
    public function obj2Arr($obj)
    {
        return ObjectHelper::obj2Arr($obj);
    }
}