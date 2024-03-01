<?php

// 获取原始的 URI
$rawUri = $_SERVER['REQUEST_URI'];

// 使用 parse_url 解析 URI，提取路径部分
$parsedUri = parse_url($rawUri);
$uri = $parsedUri['path'];
$method = $_SERVER['REQUEST_METHOD'];

// echo $uri . ' ' . $method;

// 是否有匹配的
$is_matched = false;

// 处理路由
$routes = array(
    array(
        'pattern' => '/666',
        'controller' => 'Controller/IndexController',
        'action' => 'index',
        // 是否需要认证
        'auth' => true
    ),
    array(
        'pattern' => '/login',
        'controller' => 'Controller/LoginController',
        'action' => 'login',
        'auth' => false
    ),
    array(
        'pattern' => '/test',
        'controller' => 'Controller/EventsController',
        'action' => 'getEventsByUserId',
        'auth' => true
    )
);


$matchedRoute = null;
foreach ($routes as $route) {
    if ($route['pattern'] === $uri) {
        $matchedRoute = $route;
        break;
    }
}

// 如果找到匹配的路由，则调用相应的控制器和操作
if ($matchedRoute) {
    // 设置响应头为json
    header('Content-Type: application/json');

    $is_matched = true;

    $controllerName = $matchedRoute['controller'];
    $actionName = $matchedRoute['action'];

    // 自动加载控制器类
    include_once $controllerName . '.php';
    // include_once 'Controller/EventsController.php';
    $className = basename($controllerName);

    $controller = new $className();
    // 调用相应的操作
    if (method_exists($controller, $actionName)) {
        $params = array_merge($_GET, $_POST);

        // var_dump($params);
        parse_str($parsedUri['query'] ?? '', $params);

        echo $controller->$actionName($params);
    } else {
        // 处理方法不存在的情况
        echo json_encode(['error' => 'Method Not Found']);
    }
} else {
    // 处理静态文件
    $staticFilePath = __DIR__ . '/static' . $uri;

    // 处理index
    if ($uri === '/') {
        $staticFilePath = __DIR__ . '/static/index.html';
    }

    if (file_exists($staticFilePath) && is_file($staticFilePath)) {
        // 输出静态文件
        readfile($staticFilePath);
        $is_matched = true;
    }
}


if (!$is_matched) {
    // 设置响应头为json
    header('Content-Type: application/json');
    // 如果没有匹配的路由
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
}
