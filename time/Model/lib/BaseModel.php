<?php
include 'Model.php';
class BaseModel implements Model
{
    public function __toString()
    {
        return json_encode($this->toArray());
    }

    public function fromJson($jsonString): ?BaseModel
    {
        $data = json_decode($jsonString, true);

        if ($data) {
            return static::fromArray($data);
        } else {
            return null;
        }
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function fromArray(array $data): BaseModel
    {
        $event = new static();
        foreach ($data as $key => $value) {
            if (property_exists($event, $key)) {
                $event->$key = $value;
            }
        }
        return $event;
    }
}