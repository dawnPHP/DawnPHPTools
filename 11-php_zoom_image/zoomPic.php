<?php
include('ZoomImage.class.php');
include('MyDebug.class.php');
include('Dir.class.php');

//===================================================
    //图片的等比缩放
	$img='mm.jpg';

	$dir=Dir::make_subdir() . '/';

	$thumb1 = zoomImage::zoom($img, 80, 450,1, $dir);//等比缩放，满足宽高中最合理的一个。
	$thumb2 = zoomImage::zoom($img, 200, 400,1, $dir);//等比缩放，满足宽高中最合理的一个。

	echo '<img src="'. $thumb1.'" />';
	echo '<img src="'. $thumb2.'" />';
?>