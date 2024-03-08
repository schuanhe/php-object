<?php
include_once __DIR__ . '../Utils/TokenUtil.php';
include_once __DIR__ . '/../Utils/ResponseUtil.php';

class FullcalendarController
{
    private $userId;
    private $eventsService;
    private $userService;
    // 构造函数

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $tokens = TokenUtil::checkToken();
        if ($tokens['code']) {
            $this->userId = $tokens['data']['id'];
            $this->eventsService = new EventsService();
            $this->userService = new UserService();
        }else{
            throw new Exception("请登录");
        }
    }
    // 获取用户的所有事件
    public function getAllEvents(): array
    {
        if (!isset($this->userId)) {
            return ResponseUtil::error('请登录');
        }
        return ResponseUtil::success($this->eventsService->getEventsListByUserId($this->userId));
    }

}