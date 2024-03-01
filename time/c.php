<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'Model/Events.php';

$a = new Events();

$a->setId("555");

echo $a;

