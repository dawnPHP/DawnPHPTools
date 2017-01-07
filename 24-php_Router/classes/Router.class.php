<?php 
/**=============================================
 * Router Class
 *
 * 简单的路由器
 * 类名时驼峰法，方法名是下划线法。
 *
 * @version		v1.0.0
 * @revise		2017.01.07
 * @date		2017.01.07
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/



/**
路由类：
依赖于php的反射机制。
1.实现了函数到类的凝练。能从当前url中分配变量到对应类的方法。 使用方法 Router::init();
2.产生url：由方法和变量产生url。使用方法： 	Router::make('User/index',array('id'=>5));


测试用url：http://localhost/DawnPHPTools/24-php_Router/Article/show/tag/apple/id/2017?cat=good
*/

class Router{
	static private $controller;
	static private $action;
	static private $config;//还没有使用
	static private $params=array();
	
	//初始化，这个$config参数目前没用到。
	static function init($config=array()){
		self::$config=$config;
		
		//参数和get合并，如果有同名参数，则会被get覆盖。
		$rs=self::parseURI();
		self::$controller=$rs[0];
		self::$action=$rs[1];
		self::$params=$rs[2];
		$_GET=array_merge(self::$params,$_GET);	debug($_GET);	
		
		self::dispache();
	}
	
	/**
	* 解析字符串，返回array(控制器,操作,参数数组)
	*/
	private static function parseURI($str=''){
		if($str==""){
			$str=$_SERVER['PATH_INFO'];
		}
		if(!empty($str)){
			//替换两头的斜线/
			$str=preg_replace('/\/{1,}/','/',$str);//双斜线过滤为单斜线
			$pathinfo=trim($str,'/');//  Article/index/id/2007 单用这一句，遇到双斜线会出现bug
		}else{
			$pathinfo='Index/index';
		}

		$pathinfo_arr = explode('/',$pathinfo);
		$controller=$pathinfo_arr[0];
		$action='index';

		if(count($pathinfo_arr)>1){
			$action=$pathinfo_arr[1];
		}

		$params=array();
		//获取配对的参数
		$para_count=count($pathinfo_arr)-2;
		//debug('剩余url参数个数： '.$para_count);//4
		if($para_count<0){
			$para_count=0;
		}
		if($para_count%2 != 0){
			die("parameter error: parameter not paired!");
		}else{
			for($i=0;$i<$para_count/2;$i++){
				$k=2*$i+2;
				//echo $k.'='.$pathinfo_arr[$k].'<br>';
				$params[$pathinfo_arr[$k]]=$pathinfo_arr[$k+1];
			}
		}
		
		return array($controller,$action,$params);
	}
	
	
	
	/**
	* 由控制器、方法、参数，找到对应的文件并实例化。
	*/
	private static function dispache(){
		$controller=self::$controller;
		$action=self::$action;
		//检测是否有该文件
		$controller_file=BASEPATH.'/controllers/'.$controller.'Controller.class.php';
		if (file_exists($controller_file)) {
			include $controller_file;
			$clazz=$controller.'Controller';
			if(class_exists($clazz)){
				$controller = new $clazz();
			}else{
				die('class does not exist!');
			}
				
			if (!method_exists($controller, $action)) {
				die("method does not exist!");
			} else {
				if (is_callable(array($controller, $action))) {
					//$controller->$action();
					//===========================================================
					//参数传递难题！需要反射机制，获取参数的个数，名字，顺序。
					//===========================================================
					$call=self::reflectParams($clazz,$action); 
					$arguments=$call['arguments'];//参数顺序
					$defaults=$call['defaults'];//参数默认值
					
					$para_todo=array();//需要传入类中方法的参数列表，根据url和默认值赋值。
					for($i=0;$i<count($arguments);$i++){
						$key=$arguments[$i];
						$para_todo[$key]=empty($_GET[$key])?$defaults[$i]:$_GET[$key];
					}
					//调用该方法，传入对应参数列表。
					call_user_func_array(array($controller,$action),$para_todo);	
				}else{
					die('action is not callable.');
				}
			}
		}else{
			echo 'file not exists!';
		}
	}
	
	
	
	/**
	【最难】使用反射机制，获取类中方法的参数列表，顺序，默认值。
	http://blog.csdn.net/my_yang/article/details/43882661


	通过PHP中的反射机制，获取该类的文档注释，再通过获取其所有的方法，获取方法的注释
	所用到的主要类及其方法

	eflectionClass  
	ReflectionClass::getDocComment  
	ReflectionClass::getMethods  
	  
	$method->getName()  
	$method->getDocComment();  
	$method->isProtected();  
	$method->getParameters();  
	  
	$param->getName();  
	$param->isDefaultValueAvailable();  
	$param->getDefaultValue()  


	2个参数：
		实例化后的类
		方法名
	*/
	private static function reflectParams($clazz,$action){
		
		$reflection = new ReflectionClass($clazz);
		$methods=$reflection->getMethods();
		
		//通过反射获取类的注释  (//todo 好像失败了)
		$doc = $reflection->getDocComment ();

		//解析类的注释头  
		//$parase_result =  DocParserFactory::getInstance()->parse ( $doc ); //需要lib，我没有
		$parase_result=$doc;
		$class_metadata = $parase_result;  

		//获取类中的方法，设置获取public,protected类型方法  
		$methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC + 
				ReflectionMethod::IS_PROTECTED + ReflectionMethod::IS_PRIVATE);  


		//遍历所有的方法  
		$call=array();
		foreach($methods as $method){
			//只获取我们需要的方法。如果去掉这个判断，就可以遍历类的所有方法。
			if($method->getName()!=$action){
				continue;
			}
			$arguments=array();
			$defaults=array();
			
			
			//获取方法的注释  
			$doc = $method->getDocComment();  
			//解析注释  
			//$info = DocParserFactory::getInstance()->parse($doc);  //需要lib，我没有
			$info=$doc;
			$metadata = $class_metadata +  $info;  
		
		
			//获取方法的类型  
			$method_flag = $method->isProtected();//还可能是public,protected类型的

			//获取方法的参数  
			$params = $method->getParameters(); 
			$position=0;    //记录参数的次序  
			foreach($params as $param){
				$arguments[$position]=$param->getName();
				//参数是否设置了默认参数，如果设置了，则获取其默认值  
				$defaults[$position] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : NULL; 
				$position++;
			}
			
			$call = array(  
				'class_name'=>$clazz,  
				'method_name'=>$method->getName(),  
				'arguments'=>$arguments,  
				'defaults'=>$defaults,  
				'metadata'=>$metadata,  
				'method_flag'=>$method_flag  
			);
		}
		return $call;
	}
	
	
	
	
	//看来需要消除make的负面影响。不要留有状态！
	//
	static function make($str,$params=array()){
		//1.如果没有第一个参数，报错。
		if(empty($str) || is_array($str)){
			die("must input Controler/action using string.");
		}
		//2.判断第一个参数，构建主url
		$rs=self::parseURI($str);
		$php_self=split('index.php',$_SERVER['PHP_SELF']);
		$_url=$php_self[0].$rs[0].'/'.$rs[1];
		//debug($_url);
		
		//3.设置参数设置
		$params=array_merge($rs[2],$params);
		foreach($params as $k=>$v){
			$_url .= '/'.$k.'/'.$v;
		}
		echo $_url;
	}
	
	
}