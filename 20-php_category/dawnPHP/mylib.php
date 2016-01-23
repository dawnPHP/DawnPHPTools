<?php
/******************************************
* 我自己的框架: dawnPHP v0.1.1
* 
* 引用该库入口文件即可 include('dawnPHP/door.php');
******************************************/

//定义入口文件位置
defined('BathPath') or define('BathPath', dirname(__file__) .'/' );

//1.定义字符集
header("Content-type: text/html; charset=utf-8");

//2.检测入口合法性
//定义入口路径示例 define("BathPath","D:/xampp/htdocs/php/php_user/dawnPHP/");
defined('BathPath') or die('BathPath not defined.');

//3.设置时区
date_default_timezone_set('PRC');
//date_default_timezone_set('Asia/Shanghai');

//引入配置文件
include(BathPath . 'config.php');

//4.定义css和js文件夹的上一级位置：
$publicPath='public/';

//5.数据库连接
include(BathPath . 'conn.php');

//6.引入自定义函数库
include(BathPath . 'function.php');

//7.自动加载类
/***begin****/
//定义自动加载
function myAutoload($class){
	//可以加入更多的细分目录
	$classPath=BathPath . 'class/';
	require($classPath. $class . '.class.php');
};
//注册自动加载函数
spl_autoload_register('myAutoload'); 
/***end****/
