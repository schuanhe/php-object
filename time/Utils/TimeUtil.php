<?php

class TimeUtil
{

    /**
     * 将时间戳、日期时间字符串或ISO 8601格式的时间间隔转换为相应的时间表示
     *
     * @param mixed $input 输入值，可以是普通时间戳（整数形式）、日期时间字符串或ISO 8601格式的时间间隔
     * @return int 转换后的时间戳（如果输入是日期时间字符串）或秒数（如果输入是时间间隔），原样返回时间戳（如果输入已经是时间戳）
     */
    public static function convertToTime($input)
    {
        if (preg_match('/^\d+$/', $input)) {
            return intval($input);
        } elseif (strtotime($input) !== false) {
            // 尝试转换为时间戳
            return strtotime($input);
        } else {
            try {
                // 尝试解析为 ISO 8601 时间间隔并转换为秒数
                $dateInterval = new DateInterval($input);
                return $dateInterval->y * 31536000 + $dateInterval->m * 2592000 + $dateInterval->d * 86400 + $dateInterval->h * 3600 + $dateInterval->i * 60 + $dateInterval->s;
            } catch (Exception $e) {
                // 解析失败，返回错误响应
                return 0;
            }
        }
    }


}