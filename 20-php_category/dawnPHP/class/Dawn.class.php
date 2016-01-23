<?php
class Dawn{
	//get函数
	static function get($key,$default=''){
		if(isset($_GET[$key])){
			return $_GET[$key];
		}else{
			return $default;
		}
	}
	//post函数
	static function post($key,$default=''){
		if(isset($_POST[$key])){
			return $_POST[$key];
		}else{
			return $default;
		}
	}
	//session函数-set
	static function sessionSet($key,$value){
		$_SESSION[$key]=$value;
	}
	//session函数-get
	static function sessionGet($key){
		if(isset($_SESSION[$key])){
			return $_SESSION[$key];
		}else{
			return -1;
		}
	}
	
	//to array
	public static function toArray($obj){
		$_array = is_object($obj)?get_object_vars($obj): $obj;
	 
		foreach ($_array as $key => $value) {
			$value = (is_array($value) || is_object($value)) ? Dawn::toArray($value) : $value;
			$array[$key] = $value;
		}
	 
		return $array;
	}
	
	//出错后显示 返回首页
	public static function died($text='Invalid visit.'){
		die('<br>'.$text.'<a href="javascript:window.history.back();">返回上一页</a> | <a href="index.php">返回首页</a>');
	}
	
	//返回上一页
	public static function back(){
		echo '<script type="text/javascript">window.history.back();</script>';
	}
	
	//定时返回
	public static function goBackIn($time=5,$url='',$text='Access Denied!'){
		echo "<script type='text/javascript' src='public/js/jump.js'></script>";
		echo ('<h1>:(<br>'. $text .'</h1><h3>Jump to <a href="index.php">Home</a> page in <span id="jumpTo" style="color:red"></span> second(s).</h3>');
		if($url==''){
			echo "<script>jumpToUrl($time);</script>";
		}else{
			echo "<script>jumpToUrl($time, $url);</script>";
		}
		die();
	}

}