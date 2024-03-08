<?php


//    demo();

//echo strtotime('2024-03-04');
echo 24*60*60*5;
// 初始时间段
// 传入参数：star:2023/12/1  end:2024/3/1
// 循环参数是7天，循环段为2024/3/4 - 2024/3/6时，实现效果类似：算出2023/12/1  end:2024/3/1，这期间的所有周一到周三的时间循环
// 变量：第一个时间段：2024/1/1 - 2024/1/7  ，  循环间隔：28 ，循环单位：天
// 思路：将时间段之间的时间差计算出来，然后将时间段起始位置，加上周期循环的时间戳，得到下一个周期开始的时间戳，然后加上之前的时间差，得到下一次循环结束的时间戳。上一个周期也可以这样处理,最后再将符合条件的时间段输出
// 预期结果[{2023/12/4 - 2024/12/10},{2024/1/1 - 2024/1/7},{2024/1/29 - 2024/2/4},{2024/2/25 - 2024/3/1}]

// 思路二：传入的star减去周期开始的时间，得到的差值除以周期，可以得到中间差了多少周期。循环开始时间加上（差的周期数*每个周期的秒数），得到传入时间段最近的一次循环开始时间，然后加上差值，得到循环结束时间。后面直接循环开始时间加上一个周期时间以此类推，直到到达传入时间段end

// 需要考虑大时间段和小时间段可能差的时间远，最好最少的步骤拿到最近小的时间段

//
//function demo($star="2024/1/9",$end="2024/9/30",$cycleInterval=7,$cycleUnit="day",$cycleStart="2024/3/4",$cycleEnd="2024/3/6"){
//    // 全部转为时间戳
//    $star_time = strtotime($star);
//    $end_time = strtotime($end);
//    // 周期的时间
//    $cycleInterval_time = strtotime("+".$cycleInterval." ".$cycleUnit) - time();
//    $cycleStart_time = strtotime($cycleStart);
//    $cycleEnd_time = strtotime($cycleEnd);
//    // 事件持续时间
//    $cycleDuration = $cycleEnd_time - $cycleStart_time;
//    // 算出离$star离$cycleStart的时间相差几个周期
//    $quotient = intdiv( $star_time - $cycleStart_time, $cycleInterval_time);
//    // 最近开始周期的时间,防止star时间截至导致star不显示周期，默认提前一个周期显示
//    $cycleStart_time_one = ($cycleStart_time + $quotient * $cycleInterval_time) - $cycleInterval_time;
//    demo2($star_time,$end_time,$cycleInterval_time,$cycleStart_time_one,$cycleDuration);
//}
//
//// 给出开始时间，结束时间，周期间隔时间，事件开始时间，事件持续时间
//function demo2($star_time,$end_time,$cycleInterval_time,$cycleStart_time,$cycleDuration){
//    for ($cycleStart_time_this = $cycleStart_time;$cycleStart_time_this < $end_time; $cycleStart_time_this += $cycleInterval_time) {
//        echo date('Y-m-d',$cycleStart_time_this);
//        echo "———".date('Y-m-d',$cycleStart_time_this + $cycleDuration);
//        echo "\n";
//    }
//}