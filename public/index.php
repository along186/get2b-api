<?php

// 项目名
define("APP_NAME", "api");

// 调试模式开关 测试及开发环境开启
define("APP_DEBUG", true);

// 环境变量.env变量名前缀
define("ENV_PREFIX", '');

// 定义框架目录,可更改此目录
define('FRAME_PATH', __DIR__ . '/../../thinkphp');

// 定义根目录
define('ROOT_PATH', dirname(__DIR__) . '/');

// 定义应用目录
define('APP_PATH', ROOT_PATH . 'application/');

// 配置文件目录
define('CONF_PATH', ROOT_PATH . 'config/');

// 加载框架引导文件
require FRAME_PATH . '/start.php';
