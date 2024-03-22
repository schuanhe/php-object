<?php
// 定义自动加载函数
spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);
    $fileName = ROOT_PATH .'/'. $className . '.php';
    if (file_exists($fileName)) {
        require_once $fileName;
    }

});
