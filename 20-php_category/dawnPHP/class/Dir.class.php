<?php
/**=============================================
 * Dir Class
 *
 * 文件夹操作类
 * 类名时驼峰法，方法名是下划线法。
 *
 * @version		v1.0.4
 * @revise		2016.01.23
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
	
	
	/**
		创建文件夹，如果不存在就创建，否则不创建。
		@param string $dir   路径
		@param int $mode   文件权限
	// http://www.jb51.net/article/63749.htm
	*/
	public static function mkdirs($dir, $mode = 0777){
		if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;//貌似这一行就够了
		//if (!mkdirs(dirname($dir), $mode)) return FALSE;//这行啥意思？
		//return @mkdir($dir, $mode);
	}
	
	
	/**
     * 循环删除目录和文件函数
	 * 默认是当前文件夹下，默认建立文件名为年月
	 * @version		v1.0.3
	 * @revise		2015.10.10
     * @param string $dir   根目录
     * @param string $by   新目录
     * @return string 返回子文件名
	 * http://www.jb51.net/article/38006.htm
	 * http://stackoverflow.com/questions/9361298/delete-a-directory-not-empty
     */
	/*
		//测试用例：
		include('Dir.class.php');

		echo '<pre>';
		Dir::delDirAndFiles('wjl001001001/js');
	*/
	static function delDirAndFiles( $dirName ){
		//不是文件夹则报错
		if (! is_dir($dirName)) {
			throw new InvalidArgumentException('$dirName must be a directory');
		}
		//不是/结尾，则加上斜线
		if (substr($dirName, strlen($dirName) - 1, 1) != '/') {
			$dirName .= '/';
		}
		
		//删除文件，递归删除
		$files = glob($dirName . '*');
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::delDirAndFiles($file);
			} else {
				if(unlink($file))
					echo '成功删除文件--：'. iconv('gbk','utf-8',$file). "\n";
			}
		}
		
		//删除最外层文件夹
		if( rmdir( $dirName ) ){ 
			echo '成功删除文件夹：'. iconv('gbk','utf-8',$dirName). "\n";
		}else{
			echo '删除失败：'. iconv('gbk','utf-8',$dirName). "\n";
		}
	}//end of a function 
	
	

}