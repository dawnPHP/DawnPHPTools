<?php
//自定义的微信操作类（保密内容）
//http://mp.weixin.qq.com/wiki/6/13dd4f521070e946f6ba12cedadba9a2.html

include('DawnPHP/class/MyDebug.class.php');

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
	
	//获取accessToken
	public function _getAccessToken(){
		$file='./accesstoken.txt';
		//文件存在，且不超时。保险起见，用比7200小的值
		if(file_exists($file) && (time() - filemtime($file))<7000){
			$content=file_get_contents($file);
		}else{
			//否则，重新请求微信服务器获取accessToken
			$curl=sprintf('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s', $this->_appid,$this->_appsecret);
			
			//获得新str
			$content=$this->_request($curl);
			//保存str到文件
			file_put_contents($file,$content);
		}
		
		//从str到json解码。
		$obj=json_decode($content);//从str到json解码。
		
		//自己赋值
		$this->_token=$obj->access_token;
		//返回access_token
		return $this->_token;
	}
	
	//获取QRCode二维码  //http请求方式: POST
	//http://mp.weixin.qq.com/wiki/18/8a8bbd4f0abfa3e58d7f68ce7252c0d6.html
	public function _getTicket($sceneid,$type='temp',$expire_seconds=604800){
		//数据
		if($type=='temp'){
			$data=sprintf('{"expire_seconds": %d, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": %d}}}', $expire_seconds, $sceneid);
		}else{
			$data=sprintf('{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_id": %s}}}', $sceneid);
			//POST数据：{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
			//or {"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "123"}}}
		}
		//网址
		$url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $this->_getAccessToken();
		//post请求
		$content= $this->_request($url,true,'POST',$data);
		//解码
		$json=json_decode($content);
		print_r($content);
		return $json->ticket;
	}
	
}

//===============================
/*生成带参数的二维码（QRCode:quick response code）
* http://mp.weixin.qq.com/wiki/18/8a8bbd4f0abfa3e58d7f68ce7252c0d6.html
* 临时二维码
* 永久二维码
*
* 获取带参数的二维码的过程包括两步，首先创建二维码ticket，然后凭借ticket到指定URL换取二维码。
* 场景就是一个编号。
*/
$wc=new WeChat('wx','wx','');
echo $wc->_getTicket(1);
//权限不够{"errcode":48001,"errmsg":"api unauthorized hint: [Qy0125vr23]"}
//===============================

//===============================
//使用curl获取accessToken。
/*
$wc=new WeChat('wx','wx','');
echo $wc->_getAccessToken();*/
//成功时返回{"access_token":"jq_JyIYZsFPVqQdFxU-NpkO7Uqyo6_WosFl--wVe2CXNBMdUr5rYteON2H1ydDRrwObNG_ktxxe9R3SKcFWynjO1D0qwGYRUeQQ9fYz4Q2QABWgAIADEZ","expires_in":7200}
//失败时返回{"errcode":40013,"errmsg":"invalid appid hint: [J9ayXa0958vr22]"}

//===============================


//===============================
//使用curl访问百度
/*
$wechat=new WeChat('','','');
$sth=$wechat->_request('https://www.baidu.com');


print_r( $sth );*/
//===============================