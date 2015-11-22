<?php
//引入用户信息类
include('myAgentInfo.class.php');
	
echo '<h1>用户信息记录函数 demo</h1>';

//需要记录时，只需要一行
$userInfo=new myAgentInfo();
$userInfo->log('someWordsThere');



#测试网址:     http://localhost/blog/testurl.php?id=5
/*
//获取域名或主机地址 
echo $_SERVER['HTTP_HOST']."<br>"; #localhost

//获取网页地址 
echo $_SERVER['PHP_SELF']."<br>"; #/blog/testurl.php

//获取网址参数 
echo $_SERVER["QUERY_STRING"]."<br>"; #id=5

//获取用户代理 
echo $_SERVER['HTTP_REFERER']."<br>"; 

//获取完整的url
echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br>";
echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']."<br>";
#http://localhost/blog/testurl.php?id=5

//包含端口号的完整url
echo 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]."<br>"; 
#http://localhost:80/blog/testurl.php?id=5

//只取路径
$url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]; 
echo dirname($url)."<br>";
#http://localhost/blog
*/