<?php
use Service\EventsService;


class EventsController
{
    private $eventsService;
    private $userId;

    public function __construct() {
        $this->eventsService = new EventsService();
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