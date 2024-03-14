<?php
use Service\EventsService;

class EventsController
{
    private $eventsService;

    public function __construct() {
        $this->eventsService = new EventsService();
    }

    public function getEventsByUserId($params): array
    {
        if (!isset($params['userId'])) {
            return ResponseUtil::error('请传入参数');
        }
        $userId = $params['userId'];
        return ResponseUtil::success($this->eventsService->getEventsListByUserId($userId));
    }
}