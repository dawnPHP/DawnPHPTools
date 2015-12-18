<?php
//自定义的

class WeChat{
	private $_appid;
	private $_appsecret;
	private $_token;
	
	public function __construct($_appid,$_appsecret,$_token){
		$this->_appid=$_appid;
		$this->_appsecret=$_appsecret;
		$this->_token=$_token;
	}
	
	//curl函数是用来访问http、https、ftp、ssh等协议的
	public function _request($curl,$https=true,$method='get',$data='null'){
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $curl);
		curl_setopt($ch, CURLOPT_HEADER, false);//是否需要头部
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//是否转发到变量，否则输出
		if($https){
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,true);
		}
		if($method=='POST'){
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);//传输的值
		}
		$content=curl_exec($ch);
		curl_close($ch);
		return $content;
	}
			
			
		
		
	
	

}
//===============================
//访问百度
$wechat=new WeChat('','','');
$sth=$wechat->_request('https://www.baidu.com');


print_r( $sth );
