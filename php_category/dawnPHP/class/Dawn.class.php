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

}