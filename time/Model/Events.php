<?php

include './lib/BaseModel.php';

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
     * 开始时间
     */
    protected $start_time;

    /**
     * @var string
     * 结束时间
     */
    protected $end_time;

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

}