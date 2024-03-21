<?php
use Service\EventsService;
use Service\UserService;
class FullcalendarController
{
    private $userId;
    private $eventsService;
    private $fullcalendarUtil;
    // 构造函数

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->eventsService = new EventsService();
        $this->fullcalendarUtil = new FullcalendarUtil();
    }
    // 获取用户的所有事件并且返回Full
    public function getAllEvents(): array
    {
        return ResponseUtil::success($this->eventsService->getEventsListByUserId($this->userId));
    }

    /**
     * 通过Evv
     */

    /**
     * 获取所有fullcalendar
     */
    public function getAllFullcalendar($params, $tokenData): array
    {
        if (isset($tokenData['data']['id'])) {
            $this->userId = $tokenData['data']['id'];
        }

        if (!isset($params['start'])||!isset($params['end'])) {
            // 往前30天时间戳
            $star_time = strtotime('-30 day');
            $end_time = strtotime('+30 day');
        }else{
            $star_time = strtotime($params['start']);
            $end_time = strtotime($params['end']);
        }

        $eveList = $this->eventsService->getEventsListByUserId($this->userId);
        $fullcalendarList = [];
        foreach ($eveList as $key => $value) {
            $other = [];
            // TODO: 事件显示详情时才
//            if(!empty($value['other'])){
//                $other = json_decode($value['other'],true);
//            }

            if (!empty($value['eve_name']))
                $other['title'] = $value['eve_name'];
            if (!empty($value['display']))
                $other['display'] = $value['display'];
            if (!empty($value['background_color']))
                $other['backgroundColor'] = $value['background_color'];


            $fullcalendar = $this->fullcalendarUtil->getFullcalendarByEvent(
                $value['eve_start'],$value['eve_duration'], $value['is_loop'],$value['loop_time'],
                $star_time,$end_time,$other);

            $fullcalendarList = array_merge($fullcalendar,$fullcalendarList);
        }

        return $fullcalendarList;
//        return ResponseUtil::success($fullcalendarList);
    }

}