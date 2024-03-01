<?php

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// 处理路由
$routes = array(
    array(
        'pattern' => '/',
        'controller' => 'Controller/IndexController',
        'action' => 'index'
    ),
    array(
        'pattern' => '/login',
        'controller' => 'Controller/LoginController',
        'action' => 'login'
    )
);




// 处理静态文件
$staticFilePath = __DIR__ . '/static' . $uri;

// 处理index
if ($uri === '/') {
    $staticFilePath = __DIR__ . '/static/index.html';
}

if (file_exists($staticFilePath) && is_file($staticFilePath)) {
    // 输出静态文件
    readfile($staticFilePath);
    exit;
}

// 如果没有匹配的路由
http_response_code(404);
echo json_encode(['error' => 'Not Found']);

