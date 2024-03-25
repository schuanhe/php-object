<?php

class Install
{
    public function __construct()
    {
        if (!extension_loaded('sqlite3')) {
            die('SQLite3 扩展未加载，请检查配置');
        }


    }

    public function init()
    {
        echo "开始安装数据库..." . PHP_EOL;
        //是否强制覆盖
        if (isset($_GET['force']) && $_GET['force'] == 'true') {
            unlink(DB_PATH);
        } else if (file_exists(DB_PATH)) {
            echo "数据库文件已在存在，请删除后重试！". PHP_EOL;

            echo "请带上参数 ?force=true 进行删除&重装</a>";
            exit();
        }

        // 判断DB_PATH路径是否存在
        if (!is_dir(dirname(DB_PATH))) {
            mkdir(dirname(DB_PATH), 0777, true);
        }

        $db = new SQLite3(DB_PATH);
        // 创建表
        $sql_my_events = "CREATE TABLE IF NOT EXISTS my_events (
            id INTEGER not null
	        constraint my_events_pk
		        primary key autoincrement,
	        user_id INT,
	        eve_name TEXT,
	        eve_start INTEGER,
	        eve_duration INTEGER default 86400,
	        display TEXT,
	        background_color TEXT,
	        other TEXT,
	        object_id INTEGER,
	        is_loop INT default 0,
	        loop_time INTEGER
        )";

        $db->exec($sql_my_events);

        echo "数据库(my_events)成功！" . PHP_EOL;


        $sql_my_user = "CREATE TABLE IF NOT EXISTS my_user (
            id INTEGER not null
		        primary key autoincrement,
	        name TEXT not null,
	        password TEXT
        )";

        $db->exec($sql_my_user);

        echo "数据库(my_user)成功！" . PHP_EOL;

        // 写入默认用户
        $sql_insert_user = "INSERT INTO my_users (name, password) VALUES ('admin', 'admin')";
        $db->exec($sql_insert_user);
        echo "数据库(my_users)写入默认用户成功！" . PHP_EOL;
        // 关闭数据库
        $db->close();

    }
}



