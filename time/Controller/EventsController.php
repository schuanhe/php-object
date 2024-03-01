<?php
include_once __DIR__ . '/../Service/EventsService.php';

class EventsController
{
    private $eventsService;

    public function __construct() {
        $this->eventsService = new EventsService();
    }

    public function getEventsByUserId($params): string
    {
        if (!isset($params['userId'])) {
            return json_encode(array());
        }
        $userId = $params['userId'];
        return json_encode($this->eventsService->getEventsListByUserId($userId));
    }
}
