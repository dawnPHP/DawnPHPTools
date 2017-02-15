<?php 
/**=============================================
 * Hook Class
 *
 * 钩子类
 * 类名时驼峰法，方法名是下划线法。
 *
 * @version		v1.0.0
 * @revise		2017.2.15
 * @date		2017.2.15
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/
class Hook{
	private static $hook_list=array();
	//注册函数
	static function register($hook_name,$fn_name){
		if(!isset(self::$hook_list[$hook_name])){
			self::$hook_list[$hook_name]=array();
		}
		if(is_array($fn_name)){
			self::$hook_list[$hook_name]=array_merge(self::$hook_list[$hook_name],$fn_name);
		}else{
			self::$hook_list[$hook_name][]=$fn_name;			
		}
	}
	
	//监听函数，根据传入的钩子，执行该钩子上的函数
	static function listen($hook_name,$para=array()){
		//如果存在该钩子，则执行。如果不存在，则不执行
		if(array_key_exists($hook_name, self::$hook_list)){
			//return self::$hook_list[$hook_name];
			$fns=self::$hook_list[$hook_name];
			//执行这些函数,传入一个数组参数
			//钩子函数的定义就是带一个数组参数的普通函数
			foreach($fns as $fn){
				$fn($para);
			}
		}
	}
}

