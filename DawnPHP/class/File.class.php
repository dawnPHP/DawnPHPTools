<?php
/**=============================================
 * File Class
 *
 * 文件操作类
 * 类名时驼峰法，方法名是下划线法。
 *
 * @version		v1.0.1
 * @revise		2015.10.08
 * @date		2015.10.08
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/
/*
$file = 'c:/my/mylog.txt';
$abc=File::getFileName($file);
print_r( $abc );
Array
(
    [0] => mylog
    [1] => txt
)*/
class File{
	 /**
     * 返回文件名及后缀名。
     * @param string $file_name   文件名
     * @return array 返回文件名及后缀名，不包括文件路径
     */
	static function getFileName($file_name){
		return explode(".", basename($file_name));
	}
	/*
		删除文件
	*/
	static function delete($file_name){
		if(file_exists($file_name)){
			if(unlink($file_name)){
				return true;
			}
		}else{
			return false;
		}
	}
}