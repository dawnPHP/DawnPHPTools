<?php
/**=============================================
 * Dir Class
 *
 * 文件操作类
 * 类名时驼峰法，方法名是下划线法。
 *
 * @version		v1.0.0
 * @revise		2015.10.08
 * @date		2015.10.08
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/
 
//echo Dir::make_subdir();

class Dir{
	 /**
     * 在指定文件夹下建立子文件夹，如果存在则直接返回子文件名，否则新建目录并返回子文件名
	 * 默认是当前文件夹下，默认建立文件名为年月
     * @param string $dir   根目录
     * @param string $by   新目录
     * @return string 返回子文件名
     */
	//makeSubDirIfNotExists
	static function make_subdir($dir='.',$by='m'){
		$subDir='';
		switch ($by){
			case 'm':
				$subDir .= date('Ym',time());
			break;
			default:
				$subDir .= '';
		}

		if(!file_exists($dir.'/'.$subDir)){
			if(!mkdir($dir.'/'.$subDir, 0, true)) {
				die('Failed to create folders...');
			}
		}
		return $subDir;
	}
}