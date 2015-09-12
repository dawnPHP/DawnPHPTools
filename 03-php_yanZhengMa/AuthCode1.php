<?php
/**---------------------------------------------------------------------------*/
/** PHP验证码类
/** @版权注释
/** 原创 张灿庭 如果您有任何疑问和想法可以发邮件(123294587@qq.com)
/** http://blog.csdn.net/proud2005/article/details/42775897
本类允许转载、复制和修改，但转载、复制和修改的同时请保留原始的出处和作者声明，这也是对作者劳动成果的一种尊重！
/**---------------------------------------------------------------------------*/
	//过期时间 300秒
	session_set_cookie_params(300);
	// 开启session
	session_start(); 
	//头部 防止缓存
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	
	//清除输出,去掉前面的html  
	ob_clean();
	header('Content-Type:image/gif');
	
	$code 		= 	new CodeClass();	//调用类
	$code->type	=	1;					//类型 0. 数字 1. 英文 2. 英文+数字
	$code->transparent	= 	true;		//透明
	$code->solid		=	true;		//边框
	$code->noise		=	50;			//噪点
	$code->line			=	5;			//干扰线
	$code->arc			=	2;			//弧线
	$code->dashed		=	10;			//虚线
	$code->output('AuthCode');			//输出验证码
	unset($code);






//类的定义
class CodeClass {
	private $img, $width, $height;
	public $type, $transparent, $solid, $noise, $dashed, $arc, $line;
	function __construct(){
		$this->width 	= 100;	//宽度60
		$this->height 	= 40;	//高度20
		$this->img 	= imagecreatetruecolor($this->width, $this->height);
	}
	//输出验证码
	public function output ($name){
		//透明背景
		if($this->transparent == true){
			imagefill($this->img, 0, 0, imagecolorallocate($this->img, 255, 255, 255));			//填充白色
			//imagecolortransparent($this->img, imagecolorallocate($this->img, 255, 255, 255));	//背景透明		
		}		
		//灰色边框
		if($this->solid == true){
			imagerectangle($this->img, 0, 0, $this->width-1, $this->height-1, imagecolorallocate($this->img, 204, 204, 204));
		}
		//干扰像素
		$this->drawpixel();
		//干扰线
		$this->drawline();
		//弧线
		$this->drawarc();
		//虚线
		$this->drawdashed();
		//写入文字
		$text	=	$this->text();
		$string	=	$text[0];
		$count	=	count($string);
		$width 	= 	imagefontwidth(10);		//字体宽度
		$height	= 	imagefontheight(10);		//字体高度
		$start	=	($this->width - $count * $width) / 2;	//居中
		$y 		= 	floor($this->height - $height) / 2;		//居中		
		for($i = 0; $i < $count; $i++){
			$str	=	$string[$i];
			$rgb	=	$this->color();
			$color 	= 	imagecolorallocate($this->img,	$rgb['r'], $rgb['g'], $rgb['b']);
			$x		=	empty($x) ? $start : $x + $width;
			imagestring($this->img, 5, $x, $y, $str, $color);				//横向文字
			$start 	=	$start + $width;
		}
		$_SESSION[$name] = $text[1];
		//输出图像		
		imagegif($this->img);		
	}
	//相加
	private function text (){
		$text	=	'0123456789';
		$m		=	substr($text, rand(0, strlen($text) -1), 1);
		$n		=	substr($text, rand(0, strlen($text) -1), 1);
		$str[] 	= 	array($m, '+', $n, '=', '?');
		$str[]	=	$m + $n;
		return $str;
	}
	//文字颜色
	private function color(){
		$color = array();
		//暗色
		$color[]	= 	'#000080';
		$color[]	=	'#0000EE';
		$color[]	=	'#008B00';
		$color[]	=	'#009ACD';
		$color[]	=	'#191970';
		$color[]	=	'#1C86EE';
		$color[]	=	'#2F4F4F';
		$color[]	=	'#4B0082';
		//亮色
		$color[]	=	'#CD0000';
		$color[]	=	'#8E8E38';
		$color[]	=	'#A0522D';
		$color[]	=	'#EE1289';
		$color[]	=	'#FF0000';
		$color[]	=	'#FF4500';
		$rgb		= 	$color[rand(0, count($color) - 1)];
		return $this->hColor2RGB($rgb);
	}
	//转换为rgb
	function hColor2RGB($hexColor) {
    	$color 	= str_replace('#', '', $hexColor);
        $rgb	= array(
            'r' => hexdec(substr($color, 0, 2)),
            'g' => hexdec(substr($color, 2, 2)),
            'b' => hexdec(substr($color, 4, 2))
        );
		return $rgb;
	}
	//绘制椭圆
	private function drawarc (){
		if($this->arc > 1){
			for ($i = 0; $i < $this->arc; $i++){
				$color = imagecolorallocate($this->img, rand(0, 255), rand(0, 255), rand(0, 255));
				imagearc($this->img, rand(-$this->width, $this->width), rand(-$this->height, $this->height), $this->width, $this->height, $this->width, $this->height, $color);
			}
		}
	}
	//绘制虚线
	private function drawdashed (){
		if($this->dashed > 1){
			for ($i = 0; $i < $this->dashed; $i++){
				$color = imagecolorallocate($this->img, rand(0, 255), rand(0, 255), rand(0, 255));
				imagedashedline($this->img, rand(0, $this->width), 0, rand(0, $this->width), $this->height, $color);
			}
		}
	}
	//绘制对角线
	private function drawline (){
		if($this->line > 1){
			for ($i = 0; $i < $this->line; $i++){
				$color = imagecolorallocate($this->img, rand(0, 255), rand(0, 255), rand(0, 255));
				imageline($this->img, rand(0, $this->width), 0, rand(0, $this->width), $this->height, $color);
			}
		}
	}
	//绘制噪点
	private function drawpixel(){
		if($this->noise > 1){
			for ($i = 0; $i < $this->noise; $i++){
				$color = imagecolorallocate($this->img, rand(0, 255), rand(0, 255), rand(0, 255));
				imagesetpixel($this->img, rand(0, $this->width), rand(0, $this->height), $color);
			}
		}
	}
	//析构函数
	function __destruct (){
		imagedestroy($this->img);
	}
}
?>
