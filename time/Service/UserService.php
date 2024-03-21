<?php
namespace Service;
use Utils\Database;
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
        return $this->database->queryOne($sql, $params);
    }

    public function getIdByNameAndPassword($name, $password)
    {
        $sql = "SELECT * FROM my_user WHERE name = :name AND password = :password";
        $params = array(':name' => $name, ':password' => $password);
        return $this->database->queryOne($sql, $params);
    }

    // 返回注册的id
    public function addUser($name, $password): int
    {
        $sql = "INSERT INTO my_user (name, password) VALUES (:name, :password)";
        $params = array(':name' => $name, ':password' => $password);
        return $this->database->insert($sql, $params);
    }
}