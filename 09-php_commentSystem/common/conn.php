<?php
/**
name:conn mysql
version:1.0.1
*/

//-------连接数据库---------------
//通过php连接mysql数据库：
$conn=mysql_connect('192.168.1.100','root','') or die(mysql_error());

//选择数据集
$mydb='myblog';
mysql_select_db($mydb) or die('select db Err:'.mysql_error());

//设置客户端和连接字符集
mysql_query('set names utf8');

/*
//数据库
	mysql> create database commentSys;
	Query OK, 1 row affected (0.00 sec)
	
//建表





-----------------------------------------------
-- 常用sql语句
-----------------------------------------------
1.
insert into deme(a) select (max(a)+1) from deme;

*/