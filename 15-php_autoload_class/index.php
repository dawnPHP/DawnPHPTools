<?php
header("Content-type: text/html; charset=utf-8");
echo '<h1>php自动加载类</h1>';

/************************************************
	__autoload的最大缺陷是无法有多个autoload方法 
************************************************/
//定义自动加载
function myAutoload($class){
	//可以加入更多的细分目录
	$classPath='class/';
	require($classPath. $class . '.class.php');
};
//注册自动加载函数
spl_autoload_register('myAutoload'); 
/************************************************
	end of __autoload 
************************************************/




//实例1
(new ClassA())->say();
echo '<hr>';

//实例2
(new ClassB())->say();
echo '<hr>';

//实例3-带命名空间的类
$aa=new Org\Util\ClassB();
$aa->say();