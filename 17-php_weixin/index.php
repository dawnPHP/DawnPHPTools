<?php
define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/17-php_weixin/DawnPHP/");
include('dawnPHP/mylib.php');

//记录信息
MyDebug::f($_GET,'get.txt');
MyDebug::f($_POST,'post.txt');


define("TOKEN", "201412161997");

$wechatObj = new WeChat();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}
?>