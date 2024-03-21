<?php
use Service\EventsService;

class EventsController
{
    private $eventsService;
    private $userId;

    public function __construct() {
        $this->eventsService = new EventsService();
    }
    // 新增事件
    public function addEvents($params, $tokenData): array
    {
        if (isset($tokenData['data']['id'])) {
            $this->userId = $tokenData['data']['id'];
        }

        if (!isset($params['eve_name'])||!isset($params['eve_start'])||!isset($params['eve_duration'])||!isset($params['is_loop'])||!isset($params['loop_time'])||!isset($params['other'])) {
            return ResponseUtil::error('参数不完整');
        }

        if (is_array($params['other'])) {
            $params['other'] = json_encode($params['other']);
        }

        $params['eve_start'] = TimeUtil::convertToTime($params['eve_start']);

        $params['eve_duration'] = TimeUtil::convertToTime($params['eve_duration']);
        $params['loop_time'] = TimeUtil::convertToTime($params['loop_time']);



        if (empty($params['eve_start'])||empty($params['eve_duration']))
            return ResponseUtil::error('时间格式不正确');
        if (!empty($params['is_loop'])&&empty($params['loop_time']))
            return ResponseUtil::error('循环时间不能为空');


        if ($this->eventsService->addEvents($this->userId, $params))
            return ResponseUtil::success('添加成功');
        return ResponseUtil::error('添加失败');
    }

    public function getEventsByUserId($params,$tokenData): array
    {

        if (isset($tokenData['data']['id'])) {
            $this->userId = $tokenData['data']['id'];
        }else{
            return ResponseUtil::error('token出错');
        }

        return ResponseUtil::success($this->eventsService->getEventsListByUserId($this->userId));
    }

}
