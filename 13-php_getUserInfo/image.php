<?php
//引入用户信息类
include('myAgentInfo.class.php');

//需要记录时，只需要一行
$user_info=new myAgentInfo();
$user_info->log('from image');

//输出一个透明图片
header('content-type:image/png');

$im = imagecreate(1, 1);                    // 创建1x1px的空白图像  
imagecolorallocatealpha($im, 0, 0, 0, 127); // 透明图像  
imagepng($im);                              // 输出图片  
imagedestroy($im);
?>