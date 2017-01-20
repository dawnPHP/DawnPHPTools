<?php

include("MyCurl2.php");
$curl=new MyCurl2();

//准备数据
$param['member_name']='wxx';
$param['member_passwd']='123';

$data1=array(
	"username"=>$param['member_name'],
	"password"=>trim($param['member_passwd']),
	"authkey"=>'4a416833cbb737a05fd71e0feb8e58ea'
);
//建立数据
$data2=http_build_query($data1);#http_build_query是关键！

//生成目标url
#http://www.cnblogs.com/A-Song/archive/2011/12/14/2288215.html
$path=dirname('http://'.$_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
$url = $path . "/accept.php";
//发送数据
$rs=$curl->_request($url,false,"POST",$data2);

//打印结果
echo '<hr><pre>';
var_dump($url);
var_dump($rs);
var_dump($data2);
