<?php
include_once __DIR__ . '/../Utils/Database.php';


class UserService
{
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function getUserById($userId): array
    {
        $sql = "SELECT * FROM my_user WHERE id = :id";
        $params = array(':id' => $userId);
        $user = new User();
        return $this->database->queryOne($sql, $params);
    }

    public function getIdByNameAndPassword($name, $password)
    {
        $sql = "SELECT * FROM my_user WHERE name = :name AND password = :password";
        $params = array(':name' => $name, ':password' => $password);
        return $this->database->queryOne($sql, $params);
    }
}