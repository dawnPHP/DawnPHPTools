<?php
/*****************************
* 数据库连接
* name:conn mysql
* version:1.0.1
*****************************/
//页面字符集
//header("content-type:text/html; cahrset=utf-8");

// database connection and schema constants
define('DB_HOST', '192.168.1.100');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_SCHEMA', 'myblog');
define('DB_TBL_PREFIX', '');

#1、获取连接
// establish a connection to the database server 
if (!$GLOBALS['DB'] = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)) 
{
	die('Error: Unable to connect to database server.' . mysql_error()); 
}
#2、选择数据库
if (!mysql_select_db(DB_SCHEMA, $GLOBALS['DB'])) 
{
	mysql_close($GLOBALS['DB']); 
	die('Error: Unable to select database schema.' . mysql_error()); 
}

#3、设置操作编码(建议有):校对一致
//字符转换，读库
mysql_query("set character set 'utf8'");
//写库
mysql_query("set names 'utf8'");