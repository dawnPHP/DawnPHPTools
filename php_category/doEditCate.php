<?php
session_start();
if(!isset($_SESSION['uid'])){
	die('Invalid visit.');
}
$uid=$_SESSION['uid'];

define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');

//获取数据
$action=Dawn::get('a');
switch ($action){
	case 'del':
		$cate_id=Dawn::get('cate_id');
		$result=Category::delete($cate_id,$uid);
		if($result){
			header("Location:editCate.php");
			exit();
		}else{
			die(mysql_error());
		}
		break;
	case 'send':
	
		break;
	
	
}

echo '<pre>';
print_r($_POST);

