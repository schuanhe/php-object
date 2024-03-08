<?php
include_once __DIR__ . '/../Service/EventsService.php';
include_once __DIR__ . '/../Utils/ResponseUtil.php';
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
$a = new EventsController();
echo json_encode($a->getEventsByUserId(['userId' => 1]),true);