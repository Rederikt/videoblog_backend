<?php

$connect = mysqli_connect('127.0.0.1', 'root', 'root', 'api');

if ($connect == false)
{
    echo 'Error';
    echo mysqli_connect_error();
    die();
} 