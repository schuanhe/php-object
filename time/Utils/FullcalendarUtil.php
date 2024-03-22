<?php
namespace Utils;

class FullcalendarUtil
{
    static function getFullcalendarByEvent($eve_start,$eve_duration,$is_loop,$loop_time,$star_time,$end_time,$other=[]): array
    {
        // 需不需要循环
        if ($is_loop) {
            $date = self::getLoopFull($eve_start,$eve_duration,$loop_time,$star_time,$end_time,$other);
        } else {
            $date = self::getNoLoopFull($eve_start,$eve_duration,$star_time,$end_time,$other);
        }
        return $date;
    }


    static function getNoLoopFull($eve_start,$eve_duration,$star_time,$end_time,$other): array
    {
        $date = [];
        if ($eve_start > $star_time && $eve_start < $end_time) {
            if ($eve_start + $eve_duration < $end_time) {
                // 事件结束时间小于显示结束时间 |__----__|
                // $date[] = array_merge($other,['cycleStart_time'=>$eve_start,'cycleEnd_time'=>$eve_start + $eve_duration]);
                $date[] = self::fullcalendar($eve_start,$eve_start + $eve_duration,$other);
            } else {
                // 事件结束时间大于显示结束时间 |____--|--
                // $date[] = array_merge($other,['cycleStart_time'=>$eve_start,'cycleEnd_time'=>$end_time]);
                $date[] = self::fullcalendar($eve_start,$end_time,$other);
            }
        }elseif ($eve_start + $eve_duration > $star_time){
            // 事件结束时间大于显示开始事件 --|--____|
            // $date[] = array_merge($other,['cycleStart_time'=>$star_time,'cycleEnd_time'=>$eve_start + $eve_duration]);
            $date[] = self::fullcalendar($star_time,$eve_start + $eve_duration,$other);
        }
        return $date;
    }

    static function getLoopFull($eve_start,$eve_duration,$loop_time,$star_time,$end_time,$other): array
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
            $data[] = self::fullcalendar($cycleStart_time_this,$cycleStart_time_this + $eve_duration,$other);
        }
        return $data;
    }

    static function fullcalendar($start, $end, $other): array
    {
        return array_merge($other,['start'=>date('Y-m-d\TH:i:s',$start),'end'=>date('Y-m-d\TH:i:s',$end)]);
    }

}
