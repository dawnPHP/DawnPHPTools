<?php

//记录日志的函数
function mylog($str){
	echo $str;
	file_put_contents('log.txt',$str,true);
}


//排错函数
function debug($s,$isDetal=false,$isDie=false){
	echo '<hr><pre>';
	$isDetal?var_dump($s):print_r($s);
	echo '</pre><hr>';
	if($isDie){
		die();
	}
}



/**
使用反射机制，获取类中方法的参数列表，顺序，默认值。
http://blog.csdn.net/my_yang/article/details/43882661


通过PHP中的反射机制，获取该类的文档注释，再通过获取其所有的方法，获取方法的注释
所用到的主要类及其方法

eflectionClass  
ReflectionClass::getDocComment  
ReflectionClass::getMethods  
  
$method->getName()  
$method->getDocComment();  
$method->isProtected();  
$method->getParameters();  
  
$param->getName();  
$param->isDefaultValueAvailable();  
$param->getDefaultValue()  


2个参数：
	实例化后的类
	方法名
*/
function reflectParamsArr($clazz,$action){
	
	$reflection = new ReflectionClass($clazz);
	$methods=$reflection->getMethods();
	
	//通过反射获取类的注释  
	$doc = $reflection->getDocComment ();

	//解析类的注释头  
	//$parase_result =  DocParserFactory::getInstance()->parse ( $doc ); //需要lib，我没有
	$parase_result=$doc;
	$class_metadata = $parase_result;  

	//获取类中的方法，设置获取public,protected类型方法  
	$methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC + 
			ReflectionMethod::IS_PROTECTED + ReflectionMethod::IS_PRIVATE);  


	//遍历所有的方法  
	foreach($methods as $method){
		//只获取我们需要的方法
		if($method->getName()!=$action){
			continue;
		}
		$arguments=array();
		$defaults=array();
		
		
		//获取方法的注释  
		$doc = $method->getDocComment();  
		//解析注释  
		//$info = DocParserFactory::getInstance()->parse($doc);  //需要lib，我没有
		$info=$doc;
		$metadata = $class_metadata +  $info;  
	
	
		//获取方法的类型  
		$method_flag = $method->isProtected();//还可能是public,protected类型的

		//获取方法的参数  
		$params = $method->getParameters(); 
		$position=0;    //记录参数的次序  
		foreach($params as $param){
			$arguments[$position]=$param->getName();
			//参数是否设置了默认参数，如果设置了，则获取其默认值  
			$defaults[$position] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : NULL; 
			$position++;
		}
		
		$call = array(  
			'class_name'=>$clazz,  
			'method_name'=>$method->getName(),  
			'arguments'=>$arguments,  
			'defaults'=>$defaults,  
			'metadata'=>$metadata,  
			'method_flag'=>$method_flag  
		);
	}
	return $call;
}