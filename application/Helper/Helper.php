<?php

use think\Validate as ThinkValidate;
use App\Exception\ResponsableException;

// 助手函数

if (!function_exists('env')) {

    function env($name)
    {
        return getenv(ENV_PREFIX.$name) ?? null;
    }
}

if (!function_exists('ValidateGet2b')) {

    function ValidateGet2b($data, $rule = [], $message = '')
    {
        $res = ThinkValidate::make()->check($data, $rule);
        if($res != true) {
            if($message) {
                throw new ResponsableException($message, ResponsableException::HTTP_INTERNAL_ERROR);
            } else {
                throw new ResponsableException('参数校验错误', ResponsableException::HTTP_INTERNAL_ERROR);
            }
        }
    }
}