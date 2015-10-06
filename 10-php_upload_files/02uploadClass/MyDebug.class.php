<?php
/**=============================================
 * MyDebug 我的调试类
 *
 * 集成一些短名称静态函数，便于调试
 * 类名时驼峰法，方法名是下划线法。
 *
 * @version		v1.0.0
 * @revise		2015.10.06
 * @date		2015.10.06
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/

class MyDebug{
	//显示变量
	static function p($str,$style=0){
		echo '<pre>';
		echo '<hr>';
		if($style==0){ print_r($str);
			}else{	var_dump($str);}
		echo '<hr>';
	}

}