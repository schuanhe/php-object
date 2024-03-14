<?php


class FullcalendarUtil
{
    static function getFullcalendarByEvent($eve_start,$eve_duration,$is_loop,$loop_time,$star_time,$end_time): array
    {
        // 需不需要循环
        if ($is_loop) {
            $date = self::getLoopFull($eve_start,$eve_duration,$loop_time,$star_time,$end_time);
        } else {
            $date = self::getNoLoopFull($eve_start,$eve_duration,$star_time,$end_time);
        }
        return $date;
    }


    static function getNoLoopFull($eve_start,$eve_duration,$star_time,$end_time): array
    {
        $date = [];
        if ($eve_start > $star_time && $eve_start < $end_time) {
            if ($eve_start + $eve_duration < $end_time) {
                // 事件结束时间小于显示结束时间 |__----__|
                $date[] = array('cycleStart_time'=>$eve_start,'cycleEnd_time'=>$eve_start + $eve_duration);
            } else {
                // 事件结束时间大于显示结束时间 |____--|--
                $date[] = array('cycleStart_time'=>$eve_start,'cycleEnd_time'=>$end_time);
            }
        }elseif ($eve_start + $eve_duration > $star_time){
            // 事件结束时间大于显示开始事件 --|--____|
            $date[] = array('cycleStart_time'=>$star_time,'cycleEnd_time'=>$eve_start + $eve_duration);
        }
        return $date;
    }

    static function getLoopFull($eve_start,$eve_duration,$loop_time,$star_time,$end_time): array
    {
        // 算出离$star离$eve_start的时间相差几个周期
        $quotient = intdiv( $star_time - $eve_start, $loop_time);
        // 最近开始周期的时间
        $eve_start_one = ($eve_start + $quotient * $loop_time);
        // 如果第一个周期结束时间小于start_time,则从下一个周期开始
        if($eve_start_one + $eve_duration - $loop_time > $star_time) {
            $eve_start_one -= $loop_time;
        }
        $data = [];
        for ($cycleStart_time_this = $eve_start_one;$cycleStart_time_this < $end_time; $cycleStart_time_this += $loop_time) {
            $data[] = array('cycleStart_time'=>$cycleStart_time_this,'cycleEnd_time'=>$cycleStart_time_this + $eve_duration);
        }
        return $data;
    }
}
