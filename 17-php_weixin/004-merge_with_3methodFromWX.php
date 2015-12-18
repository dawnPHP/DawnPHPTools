<?php
//自定义的微信操作类（保密内容）
//http://mp.weixin.qq.com/wiki/6/13dd4f521070e946f6ba12cedadba9a2.html

//合并官方3方法后的类。
//include('DawnPHP/class/MyDebug.class.php');

class WeChat{
	private $_appid;
	private $_appsecret;
	private $_token;
	
	public function __construct($_appid,$_appsecret,$_token){
		$this->_appid=$_appid;
		$this->_appsecret=$_appsecret;
		$this->_token=$_token;
	}
	
	//作出验证
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

	//发送信息官方函数
    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
           		$msgType = "text";
				if(!empty( $keyword ))
                {
					//============================
					switch($keyword){
						case '帮助':
							$contentStr = "1 查看地图; 2 查询酒店; \n3 查看天气; 4 查询联系方式; ";
							break;
						case '1':
							$contentStr = "查看地图在开发中";
							break;
						default:
							$contentStr = "[该指令不能识别或还在开发中]\n请直接回复数字指令.\n回复 帮助 查询指令信息。";
							break;
					}
                }else{
                	$contentStr="Input something...";
                }
				
				//============================
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
				echo $resultStr;

        }else {
        	echo "";
        	exit;
        }
    }
	
	//检查签名的官方函数
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		//$token = TOKEN;
		$token = $this->_token;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	
	
	//curl函数是用来访问http、https、ftp、ssh等协议的
	public function _request($curl,$https=true,$method='get',$data=null){
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
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
			 
			//curl_setopt($ch,CURLOPT_POST,true); 
			//curl_setopt($ch,CURLOPT_POSTFIELDS,$data);//传输的值
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
		
		//返回access_token
		return $obj->access_token;
	}
	
	//获取QRCode二维码  //http请求方式: POST
	//http://mp.weixin.qq.com/wiki/18/8a8bbd4f0abfa3e58d7f68ce7252c0d6.html
	public function _getTicket($sceneid,$type='temp',$expire_seconds=604800){
		//数据
		if($type=='temp'){
			$data=sprintf('{"expire_seconds": %d, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": %d}}}', $expire_seconds, $sceneid);
		}else{
			$data=sprintf('{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_id": %d}}}', $sceneid);
			//POST数据：{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
			//or {"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "123"}}}
		}
		//网址
		$url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $this->_getAccessToken();
		
		//post请求
		$content= $this->_request($url,true,'POST',$data);
		//解码
		$obj=json_decode($content);
		//返回ticket
		return $obj->ticket;
	}
	
	//获取二维码图
	public function _getQRCode($ticket, $sceneid,$type='temp',$expire_seconds=604800){
		if($ticket==''){
			//$ticket=$this->_getTicket($sceneid,'temp',$expire_seconds);
			$ticket='gQGz7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzlVWG0zVXZsWDN3bTlCYURsR3ZwAAIERyNyVgMEgDoJAA==';
		}
		$url='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($ticket);

		//get请求
		$content= $this->_request($url);
		return $content;
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
* /
$wc=new WeChat('wx527dd89a15670d7e','d4624c36b6795d1d99dcf0547af5443d','');
//echo $wc->_getTicket(1);
//{"ticket":"gQFS7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1QwWE9VaVBsU253enFhd3h2R3ZwAAIE1SByVgMEgDoJAA==","expire_seconds":604800,"url":"http:\/\/weixin.qq.com\/q\/T0XOUiPlSnwzqawxvGvp"}
//gQFS7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1QwWE9VaVBsU253enFhd3h2R3ZwAAIE1SByVgMEgDoJAA==

ob_end_clean();
header('Content-type:image/jpeg');
echo $wc->_getQRCode('',1);
//权限不够{"errcode":48001,"errmsg":"api unauthorized hint: [Qy0125vr23]"}
//===============================

//===============================
//使用curl获取accessToken。
/*
$wc=new WeChat('wx527dd89a15670d7e','d4624c36b6795d1d99dcf0547af5443d','');
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
?>