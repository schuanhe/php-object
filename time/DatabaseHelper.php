<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class DatabaseHelper {
    private $db;
    // 构造函数，用于连接数据库
    public function __construct() {
        // 检查 SQLite3 扩展是否加载
        if (!extension_loaded('sqlite3')) {
            die('SQLite3 扩展未加载，请检查配置');
        }
        $this->db = new SQLite3('mydatabase.db');
    }

    public function __destruct() {
        $this->db->close();
    }
    public function getConnection() {
        return $this->db;
    }

    public function query($sql) {
        // 执行查询
        return $this->db->query($sql);
    }

    public function execute($sql, $params) {
        // 执行预处理语句
        $stmt = $this->db->prepare($sql);

        // 绑定参数
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        // 执行
        return $stmt->execute();
    }

    // 单条插入
    public function insert($sql, $params) {
        // 执行
        $this->execute($sql, $params);

        // 获取自增ID
        return $this->db->lastInsertRowID();
    }

    // 单查询
    public function queryOne($sql, $params) {
        $result = $this->execute($sql, $params);
        return $result;
    }

    // 多查询
    public function queryAll($sql, $params) {
        $result = $this->execute($sql, $params);
        return $result->fetchArray(SQLITE3_ASSOC);
    }

}
