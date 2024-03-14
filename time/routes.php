<?php
// 获取原始的 URI
$rawUri = $_SERVER['REQUEST_URI'];

// 使用 parse_url 解析 URI，提取路径部分
$parsedUri = parse_url($rawUri);
$uri = $parsedUri['path'];
$method = $_SERVER['REQUEST_METHOD'];

// 设置响应头为json
header('Content-Type: application/json');

// 是否有匹配的
$is_matched = false;

// 处理路由 TODO: 从数据库加载
$routes = array(
    array(
        'pattern' => '/666',
        'controller' => 'Controller/IndexController',
        'action' => 'index',
        // 是否需要认证
        'auth' => true
    ),
    array(
        'pattern' => '/',
        'controller' => 'static/index.html',
        'action' => 'login',
        'auth' => false
    ),
    array(
        'pattern' => '/test',
        'controller' => 'Controller/EventsController',
        'action' => 'getEventsByUserId',
        'auth' => true
    ),
    array(
        'pattern' => '/api/login',
        'controller' => 'Controller/UserController',
        'action' => 'login',
        'auth' => true
    ),
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
    $controllerName = $matchedRoute['controller'];
    $actionName = $matchedRoute['action'];
    $is_matched = true;
    // TODO: 需要认证的

    if (file_exists($controllerName . '.php') && is_file($controllerName . '.php')) {
        try {
            // 自动加载控制器类
            include_once $controllerName . '.php';
            $className = basename($controllerName);
            $controller = new $className();
            // 调用相应的操作
            if (method_exists($controller, $actionName)) {
                if ($method === 'GET') {
                    parse_str($parsedUri['query'] ?? '', $params);
                } elseif ($method === 'POST') {
                    if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
                        $params = json_decode(file_get_contents('php://input'), true);
                    }else{
                        $params = $_POST;
                    }
                } else {
                    $params = [];
                }
                echo json_encode($controller->$actionName($params));
            } else {
                // 处理方法不存在的情况
                echo json_encode(ResponseUtil::error('方法不存在'));
            }
        } catch (Throwable $e) {
            // 处理实例化过程中的错误
            echo json_encode(ResponseUtil::error($e->getMessage()));
        }
    }else if (file_exists($controllerName) && is_file($controllerName)) {
        header('Content-Type: text/html');
        readfile($controllerName);
    }
}

if (!$is_matched){
    $staticFilePath = __DIR__ . '/static' . $uri . '.html';
    if ($uri === '/') {
        $staticFilePath = __DIR__ . '/static/index.html';
    }
    if (file_exists($staticFilePath) && is_file($staticFilePath)) {
        // 输出静态文件
        header('Content-Type: text/html');
        readfile($staticFilePath);
        $is_matched = true;
    }
}
// 如果没有匹配的路由
if (!$is_matched) {
    // 如果没有匹配的路由
    http_response_code(404);
    echo json_encode(ResponseUtil::notFound());
}
