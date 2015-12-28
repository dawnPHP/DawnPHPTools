<?php
session_start();
define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');


$_SESSION['uid'] = 2;
$_SESSION['username'] = '王军亮';
$_SESSION['lastlogin'] = 1449571811;
$_SESSION['usergroup'] = 2;
$_SESSION['lastBrowseTime'] = 1449571919;
/**/

function p($s,$isBR=true){ 
	echo $s;
	if($isBR) echo '<br >';
}


echo '<pre>';
p( session_name() . ' = ' , 0);
p( session_id() );

print_r($_SESSION);

if($_SESSION['uid']){
	echo $_SESSION['username'] . ' 已经登陆。<a href="index.php">回到首页</a>';
}else{
	echo '登陆正在开发中。请联系管理员。<a href="index.php">回到首页</a>';
}
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