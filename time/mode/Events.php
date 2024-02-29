<?php

include 'Model.php';

/**
 * Class Events
 */
class Events implements Model
{

    /**
     * @var int
     */
    private $id;    // id
    /**
     * @var int
     */
    private $user;  // 用户id
    /**
     * @var string
     */
    private $ev_name;   // 事件名称
    /**
     * @var int
     */
    private $start_time;    // 开始时间
    /**
     * @var int
     */
    private $end_time;  //结束时间
    /**
     * @var string
     */
    private $display;   // 显示格式
    /**
     * @var static
     */
    private $background_color;  // 背景颜色
    /**
     * @var string
     */
    private $other;     //其他配置

    /**
     * @return false|string
     */
    public function __toString()
    {
        $data = array(
            'id' => $this->id,
            'user' => $this->user,
            'ev_name' => $this->ev_name,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'display' => $this->display,
            'background_color' => $this->background_color,
            'other' => $this->other
        );

        return json_encode($data);
    }

    public static function fromJson($jsonString): ?Events
    {
        $data = json_decode($jsonString, true);

        if ($data) {
            $event = new Events();
            $event->id = $data['id'];
            $event->user = $data['user'];
            $event->ev_name = $data['ev_name'];
            $event->start_time = $data['start_time'];
            $event->end_time = $data['end_time'];
            $event->display = $data['display'];
            $event->background_color = $data['background_color'];
            $event->other = $data['other'];

            return $event;
        } else {
            // Handle JSON decoding error
            return null;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser(int $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getEvName(): string
    {
        return $this->ev_name;
    }

    /**
     * @param string $ev_name
     */
    public function setEvName(string $ev_name): void
    {
        $this->ev_name = $ev_name;
    }

    /**
     * @return int
     */
    public function getStartTime(): int
    {
        return $this->start_time;
    }

    /**
     * @param int $start_time
     */
    public function setStartTime(int $start_time): void
    {
        $this->start_time = $start_time;
    }

    /**
     * @return int
     */
    public function getEndTime(): int
    {
        return $this->end_time;
    }

    /**
     * @param int $end_time
     */
    public function setEndTime(int $end_time): void
    {
        $this->end_time = $end_time;
    }


    /**
     * @return mixed
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * @param mixed $display
     */
    public function setDisplay($display): void
    {
        $this->display = $display;
    }

    /**
     * @return mixed
     */
    public function getBackgroundColor()
    {
        return $this->background_color;
    }

    /**
     * @param mixed $background_color
     */
    public function setBackgroundColor($background_color): void
    {
        $this->background_color = $background_color;
    }

    /**
     * @return mixed
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * @param mixed $other
     */
    public function setOther($other): void
    {
        $this->other = $other;
    }


}