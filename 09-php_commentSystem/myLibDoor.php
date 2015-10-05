<?php
//打算建立一个自己的库
//这个是入口文件，做预处理的


//定义字符集
header("Content-type: text/html; charset=utf-8");

//引入自定义函数库
include('Temp_function.php');
//连接数据库
if(!isset($conn)){
	include('conn.php');
}


//设置时区
date_default_timezone_set('PRC');
//date_default_timezone_set('Asia/Shanghai');