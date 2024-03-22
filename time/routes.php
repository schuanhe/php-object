<?php
// 获取原始的 URI
use Utils\ResponseUtil;
use Utils\TokenUtil;

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
        'pattern' => '/api/getAllFullcalendar',
        'controller' => 'Controller\\FullcalendarController',
        'action' => 'getAllFullcalendar',
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
        'controller' => 'Controller\\EventsController',
        'action' => 'getEventsByUserId',
        'auth' => true
    ),
    array(
        'pattern' => '/test2',
        'controller' => 'Controller\\UserController',
        'action' => 'register',
        'auth' => false
    ),
    array(
        'pattern' => '/api/login',
        'controller' => 'Controller\\UserController',
        'action' => 'login',
        'auth' => false
    ),
    array(
        'pattern' => '/api/register',
        'controller' => 'Controller\\UserController',
        'action' => 'register',
        'auth' => false
    ),
    array(
        // 退出登录
        'pattern' => '/api/logout',
        'controller' => 'Controller\\UserController',
        'action' => 'logout',
        'auth' => false
    ),
    array(
        'pattern' => '/api/addEvents',
        'controller' => 'Controller\\EventsController',
        'action' => 'addEvents',
        'auth' => true
    ),
    array(
        'pattern' => '/api/deleteEvents',
        'controller' => 'Controller\\EventsController',
        'action' => 'deleteEvents',
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
    $tokenData = array();
    if ($matchedRoute['auth']) {
        $tokenData = authToken();
//        $tokenData = ["data"=>["id"=>1]];
    }

    if (file_exists($controllerName . '.php') && is_file($controllerName . '.php')) {
        try {
//            $className = basename($controllerName);
            $controller = new $controllerName();
            // 调用相应的操作
            if (method_exists($controller, $actionName)) {
                if ($method === 'GET') {
                    parse_str($parsedUri['query'] ?? '', $params);

                } elseif ($method === 'POST') {
                    if (isset($_SERVER['CONTENT_TYPE'])&&$_SERVER['CONTENT_TYPE'] === 'application/json') {
                        $params = json_decode(file_get_contents('php://input'), true);
                    }else{
                        $params = $_POST;
                    }
                } else {
                    $params = [];
                }
                echo json_encode($controller->$actionName($params, $tokenData));
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

// 认证
function authToken() : array
{
    try {
        $tokens = TokenUtil::checkToken();
        if ($tokens['code']) {
            return $tokens['data'];
        } else {
            echo json_encode(ResponseUtil::fail($tokens['msg']));
            exit;
        }
    } catch (Exception $e) {
        echo json_encode(ResponseUtil::fail("认证失败:".$e->getMessage()));
        exit;
    }
}