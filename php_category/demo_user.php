<?php
session_start();
define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');

echo '<pre>';
//print_r($_SESSION);

$aa=Category::cateCount(1);
print_r($aa);

/**
echo getcwd();
print_r(time());
Array
(
    [uid] => 2
    [username] => 王军亮
    [lastlogin] => 1449571811
    [usergroup] => 2
    [lastBrowseTime] => 1449571919
)
*/