<?


function demo4($url = "")
{
    // 当前时间
    $currentDate = strtotime(date('Y-m-d'));

    $initialDate = "2024-01-21";
// 将初始时间转换为时间戳
    $timestamp = strtotime($initialDate);
// 计算周期为28天
    $cycleInterval = 28;

// 最近的一次周其
    echo $currentDate;
    echo "<br>";
    echo $timestamp;


// 计算相差的秒数
    $secondsDiff = abs($currentDate - $timestamp);


// 转换为天数
    $daysDiff = floor($secondsDiff / (60 * 60 * 24));

    echo "相差的秒数: $secondsDiff, 转换为天数: $daysDiff";

    $quotient = (int)($daysDiff / $cycleInterval);
    $remainder = $daysDiff % $cycleInterval;

    echo "商: $quotient, 余数: $remainder";

    if($remainder>($cycleInterval/2)){
        $datacha = $cycleInterval-$remainder;   //相差的天数
    }else{
        $datacha = $remainder;
    }

    printArr($currentDate - $datacha*24*3600,$cycleInterval);

// 输出结果
// echo "上一次循环：$previousCycleStart 到 $previousCycleEnd\n";
// echo "当前循环：$currentCycleStart 到 $currentCycleEnd\n";
// echo "下一次循环：$nextCycleStart 到 $nextCycleEnd\n";
}

// 获取日期的后7个日期，数组格式
function getDate7($time){
    $timeAll = [];
    for ($i = 0; $i < 7; $i++) {
        $timeAll[] = date('Y-m-d', strtotime("+$i day", $time));
    }
    return $timeAll;
}

// 输出数组
function printArr($time,$cycleInterval){
    echo "<pre>";
    echo "当前周期";
    var_dump(getDate7($time));
    echo "<br>";
    echo "下一周期";
    var_dump(getDate7($time + $cycleInterval*24*3600));
    echo "<br>";
    echo "上一周期";
    var_dump(getDate7($time - $cycleInterval*24*3600));

}