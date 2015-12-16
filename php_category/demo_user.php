<?php
session_start();
define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');

/*
$_SESSION['uid'] = 2;
$_SESSION['username'] = '王军亮';
$_SESSION['lastlogin'] = 1449571811;
$_SESSION['usergroup'] = 2;
$_SESSION['lastBrowseTime'] = 1449571919;
*/

echo '<pre>';
print_r($_SESSION);
//print_r(time());


/**
$aa=Category::cateCount(1);
print_r($aa);
echo getcwd();
Array
(
    [uid] => 2
    [username] => 王军亮
    [lastlogin] => 1449571811
    [usergroup] => 2
    [lastBrowseTime] => 1449571919
)
*/