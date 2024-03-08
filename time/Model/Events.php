<?php

include_once __DIR__ . './lib/BaseModel.php';

/**
 * Class Events
 */
class Events extends BaseModel
{
    /**
     * @var int
     * id
     */
    protected $id;

    /**
     * @var int
     * 用户id
     */
    protected $user_id;

    /**
     * @var string
     * 事件名称
     */
    protected $ev_name;

    /**
     * @var string
     * 事件开始时间
     */
    protected $eve_time;

    /**
     * @var string
     * 事件持续时间
     */
    protected $eve_duration;

    /**
     * @var string
     * 显示格式
     */
    protected $display;

    /**
     * @var string
     * 背景颜色
     */
    protected $background_color;

    /**
     * @var string
     * 其他配置
     */
    protected $other;

    /**
     * @var int
     * 对象id
     */
    protected $object_id;

    /**
     * @var int
     * 是否循环
     */
    protected $is_loop;

    /**
     * @var string
     * 循环周期
     */
    protected $loop_time;

}