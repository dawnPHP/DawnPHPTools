<?php
/**=============================================
 * class Menu 微信菜单类
 *
 * 操作微信菜单的增删改
 * 类名时驼峰法，方法名是下划线法。
 *
 * @version		v1.0.0
 * @revise		2015.12.15
 * @date		2015.15.15
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/
class Menu{
	private $info='';
	
	function __construct($ACC_TOKEN,$data){
		$MENU_URL="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$ACC_TOKEN;

		$ch = curl_init(); 

		curl_setopt($ch, CURLOPT_URL, $MENU_URL); 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

		$info = curl_exec($ch);

		if (curl_errno($ch)) {
			echo 'Errno'.curl_error($ch);
		}

		curl_close($ch);		
		$this->info=$info;//返回是否添加成功的json数据，如：
		//{"errcode":48001,"errmsg":"api unauthorized hint: [qQs5La0718vr22]"}
	}
	//添加菜单
	static function add($ACC_TOKEN,$data){
		$menu=new Menu($ACC_TOKEN,$data);
		return $menu->info;
	}
}