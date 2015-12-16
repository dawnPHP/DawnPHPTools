<?php
/**=============================================
 * class ACC_TOKEN 微信ACC_TOKEN获取类
 *
 * 获取微信ACC_TOKEN，先找缓存，没有或过期再请求新ACC_TOKEN号
 * 类名时驼峰法，方法名是下划线法。
 *
 * @version		v1.0.0
 * @revise		2015.12.15
 * @date		2015.15.15
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/
/*
	1.获取access_token顺序：先寻找本地的config.php中是否有，是否有效，
	如果没有或失效，再请求重新生成
	2.使用方法：
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
		
		//echo '<pre>';
		//print_r($result);
		
		/*
		Array(
			[access_token] => xxxx
			[expires_in] => 7200  //单位:秒  2h
		)*/
		$result['addTime']=time();
		//写入配制文件
		MyConfig::array2config($result);
			
		
	}
	//提供方法
	static function get(){
		//1.先从config中获取，如果没有或过期，再生成
		$config=new MyConfig();
		$addTime=$config->get('addTime');
		if($addTime!=null){
			//如果配置文件有，则直接返回
			$last=time()-$addTime;
			if($last<($config->get('expires_in'))){
				return $config->get('access_token');
			}
		}
		//2.如果没有，或过期，则重新请求
		$acc=new ACC_TOKEN();
		return $acc->ACC_TOKEN;
	}
}
//注：access_token对应于公众号是全局唯一的票据，
//重复获取将导致上次获取的access_token失效。