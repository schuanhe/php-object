<?php
// 定义自动加载函数
spl_autoload_register(function ($className) {
    // 指定根目录
    $rootDir = __DIR__;
    autoloadClasses($className, $rootDir);
});

function autoloadClasses($className, $directory) {
    // 构建类文件路径
    $classFile = $directory . '/' . $className . '.php';
    // 检查类文件是否存在，如果存在则加载
    if (file_exists($classFile)) {
        include_once $classFile;
        return;
    }
    // 扫描目录中的子目录
    $subDirectories = glob($directory . '/*', GLOB_ONLYDIR);
    // 递归加载子目录中的类文件
    foreach ($subDirectories as $subDirectory) {
        autoloadClasses($className, $subDirectory);
    }
}