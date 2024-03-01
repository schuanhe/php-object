<?php

include './lib/BaseModel.php';

class User extends BaseModel
{
    /**
     * @var int
     * 用户ID
     */
    protected $id;

    /**
     * @var string
     * 用户名称
     */
    protected $name;

    /**
     * @var string
     * 用户密码
     */
    protected $password;

}

