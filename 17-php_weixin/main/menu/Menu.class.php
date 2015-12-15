<?php
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
		
		$this->info=$info;
	}
	//获取
	static function get($ACC_TOKEN,$data){
		//echo '<pre>';
		//echo $ACC_TOKEN;
		//echo '<hr>';
		//echo $data;
		//echo '<hr>';
		
		$menu=new Menu($ACC_TOKEN,$data);
		return $menu->info;
	}
}