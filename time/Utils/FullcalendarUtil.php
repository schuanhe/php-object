<?php


class FullcalendarUtil
{
    function getFullcalendarByEvent($eve_start,$eve_duration,$is_loop,$loop_time,$star_time,$end_time){
        // 全部转为时间戳
        $star_time = strtotime($star);
        $end_time = strtotime($end);
        // 周期的时间
        $cycleInterval_time = strtotime("+".$cycleInterval." ".$cycleUnit) - time();
        $cycleStart_time = strtotime($cycleStart);
        $cycleEnd_time = strtotime($cycleEnd);
        // 事件持续时间
        $eve_duration = $cycleEnd_time - $cycleStart_time;
        // 算出离$star离$cycleStart的时间相差几个周期
        $quotient = intdiv( $star_time - $cycleStart_time, $cycleInterval_time);
        // 最近开始周期的时间,防止star时间截至导致star不显示周期，默认提前一个周期显示
        $cycleStart_time_one = ($cycleStart_time + $quotient * $cycleInterval_time) - $cycleInterval_time;
        // 如果第一个周期结束时间小于start_time,则从下一个周期开始
        if($cycleStart_time_one + $eve_duration < $star_time){
            $cycleStart_time_one += $cycleInterval_time;
        }

        $this->demo2($star_time,$end_time,$cycleInterval_time,$cycleStart_time_one,$eve_duration);
    }

// 给出开始时间，结束时间，周期间隔时间，事件开始时间，事件持续时间
    function demo2($star_time,$end_time,$cycleInterval_time,$cycleStart_time,$eve_duration): array
    {
        $data = [];
        for ($cycleStart_time_this = $cycleStart_time;$cycleStart_time_this < $end_time; $cycleStart_time_this += $cycleInterval_time) {
            $data[] = array('$cycleStart_time'=>$cycleStart_time_this,'$cycleEnd_time'=>$cycleStart_time_this + $eve_duration);
        }
        return $data;
    }
}