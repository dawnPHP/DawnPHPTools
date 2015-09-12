<?php
session_start();
echo "<h1>showSession</h1>";
//session_destroy(); //清空以创建的所有SESSION

echo '<pre>';
print_r($_SESSION);


/*
$string = chr(rand(0xB0,0xCC)).chr(rand(0xA1,0xBB));
$string=iconv('GB2312','UTF-8',$string); //转换编码到utf8 
echo $string;
*/