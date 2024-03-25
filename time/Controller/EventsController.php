<?php

namespace Controller;

use Service\EventsService;
use Utils\ResponseUtil;
use Utils\TimeUtil;

class EventsController
{
    private $eventsService;
    private $userId;

    public function __construct()
    {
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

        if (!isset($params['id']) || empty($params['id']))
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
        } else {
            return ResponseUtil::error('token出错');
        }

        if (isset($params['id'])) {
            if ($this->eventsService->deleteEvents($this->userId, $params))
                return ResponseUtil::success('删除成功');
            return ResponseUtil::error('删除失败');
        } else {
            return ResponseUtil::error('参数不完整');
        }
    }

    public function getEventsByUserId($params, $tokenData): array
    {

        if (isset($tokenData['data']['id'])) {
            $this->userId = $tokenData['data']['id'];
        } else {
            return ResponseUtil::error('token出错');
        }
        $events = $this->eventsService->getEventsListByUserId($this->userId);
        // 处理
        foreach ($events as &$event){
            $event['eve_start'] = date('Y-m-d H:i:s', $event['eve_start']);
            $event['eve_duration'] = $this->formatDuration($event['eve_duration']);
            $event['loop_time'] = $this->formatDuration($event['loop_time']);
            $event['is_loop'] = $event['is_loop'] == 1 ? '是' : '否';
        }
        return ResponseUtil::success($events);
    }

    function formatDuration($seconds): string
    {
        // 初始化时间单位变量
        $years = floor($seconds / (3600 * 24 * 365));
        $months = floor(($seconds % (3600 * 24 * 365)) / (3600 * 24 * 30)); // 这里假设平均每月30天
        $days = floor(($seconds % (3600 * 24 * 30)) / (3600 * 24));
        $hours = floor(($seconds % (3600 * 24)) / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        // 格式化输出字符串
        $formattedDuration = '';
        if ($years > 0) {
            $formattedDuration .= $years . "年";
        }
        if ($months > 0 ) {
            $formattedDuration .= $months . "月";
        }
        if ($days > 0 ) {
            $formattedDuration .= $days . "天";
        }

        if ($hours > 0 ) {
            $formattedDuration .= $hours . "时";
        }

        if ($minutes > 0 ) {
            $formattedDuration .= $minutes . "分";
        }

        if ($seconds > 0 ) {
            $formattedDuration .= $seconds . "秒";
        }

        return $formattedDuration;
    }


    // 校验事件参数是否完整
    public function checkEventsParams(&$params, $tokenData): string
    {
        if (isset($tokenData['data']['id'])) {
            $this->userId = $tokenData['data']['id'];
        }
        if (!isset($params['eve_name']) || !isset($params['eve_start']) || !isset($params['eve_duration']) || !isset($params['is_loop']) || !isset($params['loop_time']) || !isset($params['other'])) {
            return '参数不完整';
        }
        if (is_array($params['other'])) {
            $params['other'] = json_encode($params['other']);
        }
        $params['eve_start'] = TimeUtil::convertToTime($params['eve_start']);
        $params['eve_duration'] = TimeUtil::convertToTime($params['eve_duration']);
        $params['loop_time'] = TimeUtil::convertToTime($params['loop_time']);
        if (empty($params['eve_start']) || empty($params['eve_duration']))
            return '时间格式不正确';
        if (!empty($params['is_loop']) && empty($params['loop_time']))
            return '循环时间不能为空';
        return 0;
    }

}
