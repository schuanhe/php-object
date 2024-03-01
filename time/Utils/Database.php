<?php

class Database {
    private $db;
    // 构造函数，用于连接数据库
    public function __construct() {
        // 检查 SQLite3 扩展是否加载
        if (!extension_loaded('sqlite3')) {
            die('SQLite3 扩展未加载，请检查配置');
        }
        $this->db = new SQLite3(__DIR__ . '/../Data/mydatabase.db');
    }

    public function __destruct() {
        $this->db->close();
    }
    public function getConnection(): SQLite3
    {
        return $this->db;
    }

    public function query($sql): SQLite3Result
    {
        // 执行查询
        return $this->db->query($sql);
    }

    public function execute($sql, $params): SQLite3Result
    {
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
    public function insert($sql, $params): int
    {
        // 执行
        $this->execute($sql, $params);

        // 获取自增ID
        return $this->db->lastInsertRowID();
    }

    // 单查询
    public function queryOne($sql, $params)
    {
        $result = $this->execute($sql, $params);
        return $result->fetchArray(SQLITE3_ASSOC);
    }

    // 多查询
    public function queryAll($sql, $params): array
    {
        $result = $this->execute($sql, $params);
        $rows = array();
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

}
