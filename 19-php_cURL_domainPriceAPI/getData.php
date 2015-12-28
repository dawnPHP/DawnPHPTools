<?php
//1.定义字符集
header("Content-type: text/html; charset=utf-8");
//2.设置时区
date_default_timezone_set('PRC');
//3.引入文件
include('class/MyCurl2.class.php');
include('class/DomainPrice.class.php');
//================================================

$dp=new DomainPrice(300);//单位为秒.5min=300s
echo $dp->get();