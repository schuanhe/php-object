<?php
include '../Service/EventsService.php';

class EventsController
{
    private $eventsService;

    public function __construct() {
        $this->eventsService = new EventsService();
    }

    public function getEventsByUserId($userId): array
    {
        return $this->eventsService->getEventsListByUserId($userId);
    }
}
