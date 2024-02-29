<?php


class User extends Model
{
    private $name;
    private $age;
    private $sex;
    private $phone;
    private $email;

    /**
     * User constructor.
     * @param string $name
     * @param string $age
     * @param string $sex
     * @param string $phone
     * @param string $email
     */
    public function __construct(string $name='', string $age='', string $sex='', string $phone='', string $email='')
    {
        $this->name = $name;
        $this->age = $age;
        $this->sex = $sex;
        $this->phone = $phone;
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


}