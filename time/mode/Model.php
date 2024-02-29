<?php


interface Model
{
    function __toString();
    static function fromJson($jsonString);
}