<?php
//demo2.基本功能，1.地址分发，2.url生成U('User/index',array('id'=>12))

if(!empty($_SERVER['PATH_INFO'])){
	//替换两头的斜线/
	$_SERVER['PATH_INFO']=preg_replace('/\/{1,}/','/',$_SERVER['PATH_INFO']);//双斜线过滤为单斜线
	$pathinfo=trim($_SERVER['PATH_INFO'],'/');//  Article/index/id/2007 单用这一句，遇到双斜线会出现bug
}else{
	$pathinfo='Index/index';
}

$pathinfo_arr = explode('/',$pathinfo);
$controller=$pathinfo_arr[0];
$action='index';

if(count($pathinfo_arr)>1){
	$action=$pathinfo_arr[1];
}
//debug($pathinfo_arr);
/*
Array
(
    [0] => Article
    [1] => index
    [2] => tag
    [3] => apple
    [4] => id
    [5] => 2007
)
*/

$paras=array();
//获取配对的参数
$para_count=count($pathinfo_arr)-2;
//debug('剩余url参数个数： '.$para_count);//4
if($para_count<0){
	$para_count=0;
}
if($para_count%2 != 0){
	die("parameter error: parameter not paired!");
}else{
	for($i=0;$i<$para_count/2;$i++){
		$k=2*$i+2;
		//echo $k.'='.$pathinfo_arr[$k].'<br>';
		$paras[$pathinfo_arr[$k]]=$pathinfo_arr[$k+1];
	}
}
//参数和get合并，如果有同名参数，则会被get覆盖。
$_GET=array_merge($paras,$_GET);







//检测是否有该文件
$controller_file=BASEPATH.'/controllers/'.$controller.'Controller.class.php';
if (file_exists($controller_file)) {
	include $controller_file;
	$clazz=$controller.'Controller';
	if(class_exists($clazz)){
		$controller = new $clazz();
	}else{
		die('class does not exist!');
	}
		
	if (!method_exists($controller, $action)) {
		die("method does not exist!");
	} else {
		if (is_callable(array($controller, $action))) {
			//$controller->$action();
			//===========================================================
			//参数传递难题！需要反射机制，获取参数的个数，名字，顺序。
			//===========================================================
			$call=reflectParamsArr($clazz,$action); 
			$arguments=$call['arguments'];//参数顺序
			$defaults=$call['defaults'];//参数默认值
			
			$para_todo=array();//需要传入类中方法的参数列表，根据url和默认值赋值。
			for($i=0;$i<count($arguments);$i++){
				$key=$arguments[$i];
				$para_todo[$key]=empty($_GET[$key])?$defaults[$i]:$_GET[$key];
			}
			//调用该方法，传入对应参数列表。
			call_user_func_array(array($controller,$action),$para_todo);	
		}else{
			die('action is not callable.');
		}
	}
}else{
	echo 'file not exists!';
}

/*
http://localhost/DawnPHPTools/24-php_Router/Article/show/tag/apple/id/2017?cat=good
*/
