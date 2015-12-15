<?php
/**=============================================
 * MyDebug 我的调试类
 *
 * 集成一些短名称静态函数，便于调试
 * 类名时驼峰法，方法名是下划线法。
	v1.0.2 增加了后面的换行、追加。
 *
 * @version		v1.0.2
 * @revise		2015.10.08
 * @date		2015.10.06
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/

class MyDebug{
	/*
		直接打印变量
		http://www.myexception.cn/php/352225.html
	*/
	static function p($var,$style=0){
		echo '<pre>';
		echo '<hr>';
		if($style==0){ print_r($var);
			}else{	var_dump($var);}
		echo '<hr>';
	}
	/*
		输出变量到文件
		http://www.myexception.cn/php/352225.html
	*/
	static function f($var, $file_name='debug.txt'){
		$s = print_r($var, true);
		$s = self::wrap($s);
		file_put_contents($file_name, $s,FILE_APPEND);
	}
	
	/*
		日志输出：PHP中file_put_contents追加和换行
		http://www.dodobook.net/php/1048
	*/
	static function log($var, $file_name='log.txt'){
		$s = print_r($var, true);
		$s = self::wrap($s);
		file_put_contents($file_name, $s,FILE_APPEND);
	}
	
	
	//==============================包装输出格式
	/*add time*/
	static function wrap($s){
		$s  = self::t() . $s . PHP_EOL;
		$s .= PHP_EOL . '===========================' . PHP_EOL;
		return $s;
	}
	
	/*获取当前时间*/
	static function t(){
		date_default_timezone_set('PRC');
		$time  = PHP_EOL . '===========================' . PHP_EOL;
		$time .= date('Y-m-d H-i-s',time());
		$time .= PHP_EOL . '----------------------------' . PHP_EOL;
		return $time;
	}
}