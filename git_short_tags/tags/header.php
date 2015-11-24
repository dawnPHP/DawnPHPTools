<?php 
//1.编码方式head头
header("Content-type: text/html; charset=utf-8");

//2.设置时区
date_default_timezone_set('PRC');

//3.从session获取u_id
$u_id=1;

?>
<html>
<head>
<link rel="stylesheet" href="tags.css" />
<title>仿163博客添加文章标签功能</title>
</head>
<body>
<h1>仿163博客添加文章标签功能</h1>
<pre>
1.前台基于js，后台基于php。
2.完稿后第一行隐藏，用于提交表单：用户添加的标签。
3.贴吧：http://tieba.baidu.com/p/4174331708
</pre>
<a href='index.php'>首页</a> | 
<a href='new.php'>新建</a>
<hr/>