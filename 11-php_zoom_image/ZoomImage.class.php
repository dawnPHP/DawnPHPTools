<?php
/**=============================================
 * ZoomImage Class
 *
 * 图片缩放类
 * 类名时驼峰法，方法名是下划线法。
 *
 * @version		v1.0.0
 * @revise		2015.10.06
 * @date		2015.10.06
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/

/**
  对图片进行等比例缩放
  
  $filetype 最终生成的图片类型1 2 3（.jpg/.png/.gif）
*/
class ZoomImage{
	//防止同一时刻出现多个文件的重名
	private static $count=0;
	
	/**
		图片缩放函数
	*/
	static function zoom($originImage_name, $width, $height,$type=1, $dir=''){
	//$type指定小图类型功能没有实现
		/*
	Array
	(
		[0] => 910 //width
		[1] => 1365  //height
		[2] => 2   //2->jpg
		[3] => width="910" height="1365"
		[bits] => 8
		[channels] => 3
		[mime] => image/jpeg
	)
		*/
		//取得源图片的宽度和高度
		$size_src=getimagesize($originImage_name);
		$w=$size_src['0'];
		$h=$size_src['1'];
		
		//echo '<pre>';print_r($size_src); die();
		
		//根据长宽计算缩放的比例
		if($width/$w < $height/$h){
			$ratio=$width/$w;
		}else{
			$ratio=$height/$h;
		}    
		//根据比例，计算缩放后的图片宽度和高度
		$width=$ratio*$w;
		$height=$ratio*$h;
		
		//新图：声明一个$width宽，$height高的真彩图片资源
		$thumbnail=imagecreatetruecolor($width, $height);
		//源图：因为PHP只能对资源进行操作，所以要对需要进行缩放的图片进行拷贝，创建为新的资源
		$originImage=imagecreatefromjpeg($originImage_name);
		
		//关键函数，参数（新图资源，源，
		//新图资源的开始坐标x,y, 	源资源的开始坐标x,y,
		//新图资源的宽高width,height,		源资源的宽高w,h）
		imagecopyresampled($thumbnail, $originImage, 0, 0, 0, 0, $width, $height, $w, $h);
		
		//告诉浏览器以图片形式解析
		//1 = GIF，2 = JPG，3 = PNG，
		$type= $type==''?($size_src['2']):$type ;

		switch ($type){
			case 1:
				$imgfn=array('imagegif','.gif');//
				break;
			case 2:
				$imgfn=array('imagejpeg','.jpg');
				break;
			case 3:
				$imgfn=array('imagepng','.png');
				break;
			default:
				die('Image Type Error!');
				//throw 'Image Type Error!';
		}
		//动态函数输出小图
		$name=explode(".", basename($originImage_name));
		$thumbnail_name=$dir . 'small_' . date('Ymdhis',time()) .'_'. (self::$count) .'_'. $name[0] . $imgfn[1];
		self::$count++;
		header('content-type:'. $size_src['mime']);
		$imgfn[0]($thumbnail, $thumbnail_name);

		
		//销毁资源
		imagedestroy($thumbnail);
		imagedestroy($originImage);
		
		//返回小图文件名
		header("Content-type: text/html; charset=utf-8");
		return $thumbnail_name;
	}
}