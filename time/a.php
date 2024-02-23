<?php


// SQLite数据库文件路径
$databaseFile = 'mydatabase.db';

// 创建SQLite连接
$db = new SQLite3($databaseFile);

// 检查连接是否成功
if (!$db) {
    die("无法连接到数据库");
}

// 创建表的SQL语句
$tableCreationQuery = "
    CREATE TABLE IF NOT EXISTS my_table (
        id INTEGER PRIMARY KEY,
        name TEXT NOT NULL,
        age INTEGER
    )
";

// 执行SQL语句来创建表
$db->exec($tableCreationQuery);

// 关闭数据库连接
$db->close();

echo "表创建成功";


