<?php
session_start();

//生成随机字符串
function creaStr($len){
     $arr1=range(0,9);
     $arr2=range(a,z);
     $arr3=range(A,Z);
     $arr=array_merge($arr1,$arr2,$arr3);
     str_shuffle($arr);
     $str="";
     for($i=0;$i<$len;$i++){
            $str.=$arr[rand(0,61)];
     }
    return $str;
}



//使用GD库创建图片

//图像大小
$sizeX=150;//75
$sizeY=50;//25
$image = imagecreatetruecolor($sizeX,$sizeY); //创建画布
$back = imagecolorallocate($image, 255, 255, 255);//定义背景色
$border = imagecolorallocate($image, 0, 0, 0);//定义边框
imagefilledrectangle($image, 0, 0, $sizeX - 1, $sizeY - 1, $back);
imagerectangle($image, 0, 0, $sizeX - 1, $sizeY - 1, $border);


$font='apple_handwritten.ttf'; //字体文件：目录下一定要有，文件名不能有空格
$str=creaStr(4); //字符串

$_SESSION['validationcode']=$str;//保存验证码到session中

for($i=0,$j=5;$i<4;$i++){
      $array = array(-1,1);
      $p = array_rand($array);
      $an = $array[$p]*mt_rand(1,10); //扭曲角度
      $size = 35;//字体大小
	  $randColor=imagecolorallocate($image,rand(0,100),rand(0,100),rand(0,100));
      //imagettftext($image, $size, $an, $j,rand(13,20),$randColor, $font, $str[$i]);//生成验证字符串（字符位置）
      imagettftext($image, $size, $an, $j,rand(53,30),$randColor, $font, $str[$i]);//生成验证字符串
      //$j+=15;
      $j+=35;//字间距
}
//清除输出,去掉前面的html  
ob_clean();  
header("Content-type:image/png");
//输出图片
imagepng($image);
//注销图片
imagedestroy($image);
?>