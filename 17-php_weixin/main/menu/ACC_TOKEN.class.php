<?php
/*
	获取access_token
	使用方法：
		引用Secret类和ACC_TOKEN类;
		$acc=ACC_TOKEN::get();
*/
class ACC_TOKEN{
	private $ACC_TOKEN='';
	
	function __construct(){
		//敏感信息放到了外部文件
		$APPID=Secret::$APPID;
		$APPSECRET=Secret::$APPSECRET;
		//获取access_token
		$TOKEN_URL="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $APPID . "&secret=" . $APPSECRET;
		$json=file_get_contents($TOKEN_URL);
		$result=json_decode($json,true);
		//赋值给类的私有变量
		$this->ACC_TOKEN=$result['access_token'];
		
		echo '<pre>';
		print_r($result);
		
		/*
		Array(
			[access_token] => xxxx
			[expires_in] => 7200  //单位:秒  2h
		)*/
		
		
	}
	//提供方法
	static function get(){
		
		$acc=new ACC_TOKEN();
		return $acc->ACC_TOKEN;
	}
}
//注：access_token对应于公众号是全局唯一的票据，重复获取将导致上次获取的access_token失效。
?>