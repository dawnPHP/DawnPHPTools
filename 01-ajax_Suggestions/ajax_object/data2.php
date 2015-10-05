<?php
//获取数据
$msg=array();

if(isset($_GET)){
	$msg['get2']=$_GET;
}

if(isset($_POST)){
	$msg['post2']=$_POST;
}

//编码成json返回
echo json_encode( $msg );