<?php
/**
name:conn mysql
version:1.0.1
*/

//-------连接数据库---------------
//通过php连接mysql数据库：
$conn=mysql_connect('127.0.0.1','root','') or die(mysql_error());

//选择数据集
mysql_select_db('myblog') or die(mysql_error());

//设置客户端和连接字符集
mysql_query('set names utf8');
