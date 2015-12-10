<?php
session_start();
echo '<pre>';
print_r($_SESSION);

print_r(time());
//echo getcwd();
/**
Array
(
    [uid] => 2
    [username] => 王军亮
    [lastlogin] => 1449571811
    [usergroup] => 2
    [lastBrowseTime] => 1449571919
)
*/