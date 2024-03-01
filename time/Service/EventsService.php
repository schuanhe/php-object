<?php

include '../Utils/Database.php';
include '../Model/Events.php';

class EventsService
{
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    /*
     * 获取用户信息
     */
    public function getEventsListByUserId($userId): array
    {
        $sql = "SELECT * FROM my_events WHERE user_id = :user";
        $params = array(':user' => $userId);
        return $this->database->queryAll($sql, $params);
    }
}