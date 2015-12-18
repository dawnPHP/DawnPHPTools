<?php
/**
  * wechat php test
  */

//define your token

include('../MyDebug.class.php');
include('../WeChat.class.php');

$wc=new WeChat('wx527dd89a15670d7e','d4624c36b6795d1d99dcf0547af5443d','');

define("TOKEN", "201412161997");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();

?>