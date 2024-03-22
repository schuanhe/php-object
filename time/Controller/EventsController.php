<?php
namespace Controller;
use Service\EventsService;
use Utils\ResponseUtil;
use Utils\TimeUtil;

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
        $msg = $this->checkEventsParams($params, $tokenData);
        if ($msg) return ResponseUtil::error($msg);

        if ($this->eventsService->addEvents($this->userId, $params))
            return ResponseUtil::success('添加成功');
        return ResponseUtil::error('添加失败');
    }

    public function updateEvents($params, $tokenData): array
    {
        $msg = $this->checkEventsParams($params, $tokenData);
        if ($msg) return ResponseUtil::error($msg);

        if (!isset($params['id'])||empty($params['id']))
            return ResponseUtil::error('参数不完整');

        if ($this->eventsService->updateEvents($this->userId, $params))
            return ResponseUtil::success('修改成功');
        return ResponseUtil::error('修改失败');
    }

    // 删除
    public function deleteEvents($params, $tokenData): array
    {
        if (isset($tokenData['data']['id'])) {
            $this->userId = $tokenData['data']['id'];
        }else{
            return ResponseUtil::error('token出错');
        }

        if (isset($params['id'])) {
            if ($this->eventsService->deleteEvents($this->userId, $params))
                return ResponseUtil::success('删除成功');
            return ResponseUtil::error('删除失败');
        }else{
            return ResponseUtil::error('参数不完整');
        }
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

    // 校验事件参数是否完整
    public function checkEventsParams(&$params, $tokenData): string
    {
        if (isset($tokenData['data']['id'])) {
            $this->userId = $tokenData['data']['id'];
        }
        if (!isset($params['eve_name'])||!isset($params['eve_start'])||!isset($params['eve_duration'])||!isset($params['is_loop'])||!isset($params['loop_time'])||!isset($params['other'])) {
            return '参数不完整';
        }
        if (is_array($params['other'])) {
            $params['other'] = json_encode($params['other']);
        }
        $params['eve_start'] = TimeUtil::convertToTime($params['eve_start']);
        $params['eve_duration'] = TimeUtil::convertToTime($params['eve_duration']);
        $params['loop_time'] = TimeUtil::convertToTime($params['loop_time']);
        if (empty($params['eve_start'])||empty($params['eve_duration']))
            return '时间格式不正确';
        if (!empty($params['is_loop'])&&empty($params['loop_time']))
            return '循环时间不能为空';
        return 0;
    }

}
