<?php
session_start();
define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');

$dawn=new Dawn();

$uid=$dawn->get('uid',-1);
//MyDebug::f( $_SESSION['uid'] );


$cate=array();
if($_SESSION['uid']==$uid || $uid==-1){
	$cate=Category::getByUserId($_SESSION['uid']);	
	echo json_encode($cate);
}else{
	echo '';
}