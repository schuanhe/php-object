<?php
use Service\UserService;

class UserController
{
    private $userService;

    public function __construct(){
        $this->userService = new UserService();
    }

    // 登录
    public function login($params): array
    {
        if (empty($params['name']) || empty($params['password'])) {
            return ResponseUtil::error('请传入参数');
        }
        $name = $params['name'];
        $password = $params['password'];
        $user = $this->userService->getIdByNameAndPassword($name, $password);
        if (empty($user)) {
            return ResponseUtil::fail('用户名或密码错误');
        }
        // 生成token
        $token = TokenUtil::generateToken(['id'=>$user['id']],3600 * 24 * 3);
        $data = [
            'token' => $token,
        ];

        // 设置cookie
        setcookie('token', $token, time() + (3600 * 24 * 3), '/');

        return ResponseUtil::success($data, '登录成功');
    }

    // 退出
    public function logout(): array
    {
        // 清除cookie
        setcookie('token', '', time() - 3600, '/');
        return ResponseUtil::success('退出成功');
    }

    // 注册
    public function register($params): array
    {
        if (empty($params['name']) || empty($params['password'])) {
            return ResponseUtil::error('请传入参数');
        }
        $name = $params['name'];
        $password = $params['password'];
        $id = $this->userService->addUser($name, $password);
        if ($id > 0) {
            $token = TokenUtil::generateToken(['id'=>$id],3600 * 24 * 3);
            $data = [
                'token' => $token,
            ];
            setcookie('token', $token, time() + (3600 * 24 * 3), '/');
            return ResponseUtil::success($data, '注册成功');
        }
        return ResponseUtil::fail('注册失败');
    }
}