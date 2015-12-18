<?php
/**
  * wechat php test
  */
//include('../MyDebug.class.php');
include('../DawnPHP/class/MyDebug.class.php');
include('WeChat.class.php');

//定义常量
define('APPID','wx527dd89a15670d7e');
define('APPSECRET','d4624c36b6795d1d99dcf0547af5443d');
define('TOKEN','201412161997');

//实例化，回应
$wc=new WeChat(APPID, APPSECRET, TOKEN);
echo $wc->valid_js();
?>