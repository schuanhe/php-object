<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class DatabaseHelper {

    private $db;

    // 构造函数，用于连接数据库
    public function __construct($databaseFile) {

        // 检查 SQLite3 扩展是否加载
        if (!extension_loaded('sqlite3')) {
            die('SQLite3 扩展未加载，请检查配置');
        }

        $this->db = new SQLite3($databaseFile);

        // 检查连接是否成功
        if($this->db->lastErrorMsg()) {
            die($this->db->lastErrorMsg());
        }else{
            echo "数据库连接成功";
        }
    }

    public function __destruct() {
        $this->db->close();
    }

    public function getConnection() {
        return $this->db;
    }
}




// 使用例子
$databaseFile = 'mydatabase.db';
$dbHelper = new DatabaseHelper($databaseFile);

echo  "数据库连接成功";
// 获取数据库连接
//$db = $dbHelper->getConnection();
//
//// 使用数据库
//$sql = "SELECT * FROM users";
//$result = $db->query($sql);
//
//
//while($row = $result->fetchArray(SQLITE3_ASSOC)) {
//    print_r($row);
//}
//
//
