<?php
include_once __DIR__ . '/../Service/EventsService.php';

class EventsController
{
    private $eventsService;

    public function __construct() {
        $this->eventsService = new EventsService();
    }

    public function getEventsByUserId($userId = 1): string
    {
        return JSON_encode($this->eventsService->getEventsListByUserId($userId));
    }
}
