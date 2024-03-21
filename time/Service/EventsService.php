<?php
namespace Service;
use Utils\Database;

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

    public function addEvents($userId, $params): bool
    {
        $sql = "INSERT INTO my_events (user_id, eve_name, eve_start, eve_duration, is_loop, loop_time, other) VALUES (:user, :eve_name, :eve_start, :eve_duration, :is_loop, :loop_time, :other)";
        if (isset($params['eve_name'])&&isset($params['eve_start'])&&isset($params['eve_duration'])&&isset($params['is_loop'])&&isset($params['loop_time'])&&isset($params['other'])) {
            $params = array(':user' => $userId, ':eve_name' => $params['eve_name'], ':eve_start' => $params['eve_start'], ':eve_duration' => $params['eve_duration'], ':is_loop' => $params['is_loop'], ':loop_time' => $params['loop_time'], ':other' => $params['other']);
            if ($this->database->execute($sql, $params)) {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }
}