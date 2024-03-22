<?php
// 定义自动加载函数
spl_autoload_register(function ($className) {
    $rootDir = __DIR__;
    $fileName = $rootDir .'\\'. $className . '.php';
    if (file_exists($fileName)) {
        require_once $fileName;
    }

});
