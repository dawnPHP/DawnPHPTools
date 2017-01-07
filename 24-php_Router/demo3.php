<?php

//2.测试预设定文件引入和起作用



// 应用入口文件
date_default_timezone_set("Asia/Shanghai");
header('Content-type: text/html;charset=utf-8');
// 项目根路径
define('BASEPATH', dirname(__FILE__));
// 调试模式
define('APP_DEBUG', True);
// 引入配置文件
$router= include BASEPATH . '/config/config2.php';
debug($router);


//获取当前访问的url
function getCurrentQuery($pathinfo='',$isArray=false){
	//$_SERVER['PATH_INFO']    // /Article/index/id/2007/
	if($pathinfo==""){
		$pathinfo=trim($_SERVER['PATH_INFO'],'/');//  Article/index/id/2007
	}
		
	if($isArray) return $pathinfo;
	/*  Article/index/id/2007  */
	
	$pathinfo_arr = explode('/',$pathinfo); 	
	return $pathinfo_arr;
	/*
	Array
		(
			[0] => Article
			[1] => index
			[2] => id
			[3] => 2007
		)
	*/
}



/*
http://www.nowamagic.net/librarys/veda/detail/1938
*/

//1.测试控制器是否存在与config中
//http://blog.csdn.net/helencoder/article/details/52065969
$request_path = getCurrentQuery()[0];
debug($request_path);
if (array_key_exists($request_path, $router)) {
	$arr=explode('/',trim($router[$request_path]));
	debug($arr);die();

	
	if (file_exists($module_file)) {
		include $module_file;
		$obj_module = new $class_name();
		if (!method_exists($obj_module, $method_name)) {
			die("要调用的方法不存在");
		} else {
			if (is_callable(array($obj_module, $method_name))) {
				$obj_module->$method_name($request_query, $_POST);
			}
		}
	} else {
		die("定义的模块不存在");
	}
}	


debug($request_query);

$ary_url=array(
	'controller'=>'Index',
	'method'=>'index',
	'pramers'=>array()
);




