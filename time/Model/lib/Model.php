<?php


interface Model
{
    function __toString();
    function fromJson($jsonString);
    function toArray();
    function fromArray(array $data);
}
