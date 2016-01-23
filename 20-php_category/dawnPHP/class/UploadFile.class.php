<?php
/**=============================================
 * UploadFile 上传类
 *
 * 单文件上传
 * 类名时驼峰法，方法名是下划线法。
 *
 * @version		v1.0.1
 * @revise		2016.01.23
 * @date		2015.10.06
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/

	/*对于多文件上传，
		需要先使用UploadFile类的静态方法rearrange_files_array重组数组，
		再接着按照单文件上传的方法进行处理。
		后续会写多文件上传的。*/

//文件上传 http://www.w3school.com.cn/php/php_file_upload.asp
//注意兼容: 对于 IE，识别 jpg 文件的类型必须是 pjpeg，对于 FireFox，必须是 jpeg。
/*
Array
(
    [file] => Array
        (
            [name] => loading_big.gif
            [type] => image/gif
            [tmp_name] => C:\xampp\tmp\php9279.tmp
            [error] => 0
            [size] => 2700  //(b)
        )
)
*/
	
class UploadFile{
	static private $count=0;
	private $file='';
	private $restricts=array(
				'size'=>200, //unit: kb
				'type'=>array("image/gif", "image/jpeg", "image/pjpeg", "image/png","image/bmp")
			);
			
	/*构造函数传入文件
	*/
	public function __construct($file){
		$this->file=$file;
	}
	/*设定限定条件
	*/
	public function set_restricts($restricts){
		$this->restricts=$restricts;
	}
	
	/*
		返回文件信息
	*/
	public function get_info(){
		$file=$this->file;
		
		if ($file["error"] > 0){
			$msg = "Error: " . $file["error"] . "<br />";
		}else{
			$msg = "Upload: " . $file["name"] . "<br />";
			$msg .= "Type: " . $file["type"] . "<br />";
			$msg .= "Size: " . ($file["size"] / 1024) . " Kb<br />";
			$msg .= "Stored in: " . $file["tmp_name"];
		}

		return $msg;
	}
	
	/*
		判断上传文件是否符合限制条件
		比如一个限制条件，
		传入的限制条件会影响该类的限制条件。
		return 返回数组:第一位是否成功，第二位描述
	*/
	function isValid($restricts=''){
		$file=$this->file;
		
		//如果缺省限制条件，则用默认限制条件。
		if($restricts==''){
			$restricts=$this->$restricts;
		}else{
			$this->set_restricts($restricts);
		}
		
		//大小限制
		if( ($file['size']/1024)>$restricts['size'] ) 
			return array(0,'Invalid: the size is too big');
		//格式限制
		if( !in_array($file["type"], $restricts['type']) )
			return array(0,'Invalid: the type is incorrect');
			
		//通过验证
		return array(1,'Valid: the file is valid');
	}
	
	//返回唯一值作为文件名，后缀名和之前一致为了防止同一时间，加了静态变量
	function getName($oldfile){
		$num='_'.self::$count++;
		$aa=explode('.', $oldfile);
		$ext=end($aa);
		return date('YmdHis',time()) . $num . '.' . $ext;
	}
	/*
	* 执行上传命令
	* $dir_name是目的路径（以/结尾）
	* 注意：中文文件名需要转码（utf-8 to gbk）
	*/
	function upload_to($dir_name="upload/",$isOriginName=true){
		//判断文件是否合法
		$arr=$this->isValid($this->restricts);
		if( $arr[0]==0 )
			return $arr;
		
		//判断路径末尾是否有斜线
		if( substr($dir_name, -1) !='/' ){
			$dir_name = $dir_name.'/';
		}
		//如果不存在，就新建文件夹
		Dir::mkdirs( $dir_name );
		
		$file=$this->file;//获取文件
		if($isOriginName){
			$final_img_name=$file["name"];
		}else{
			$final_img_name=$this->getName($file["name"]);
		}
		
		if (file_exists($dir_name . $final_img_name)){
			return array(0, $final_img_name . " already exists. ");
		}else{
			$to=iconv("UTF-8","GB2312//IGNORE",$final_img_name);
			//网页是utf8, 而win7文件系统是gbk
			move_uploaded_file($file["tmp_name"],
			$dir_name . $to);//上传文件
			return array(1, $dir_name . $final_img_name);
		}
	}
	
		
	/**
		静态方法：递归返回文件列表 从php.net的评论中摘抄下来的，没看懂
	*/
	static function rearrange_files_array(array $array) {
		foreach ($array as &$value) {
			$_array = array();
			foreach ($value as $prop => $propval) {
				if (is_array($propval)) {
					array_walk_recursive($propval, function(&$item, $key, $value) use($prop) {
						$item = array($prop => $item);
					}, $value);
					$_array = array_replace_recursive($_array, $propval);
				} else {
					$_array[$prop] = $propval;
				}
			}
			$value = $_array;
		}
		return $array;
	}
	
}//end of the class
