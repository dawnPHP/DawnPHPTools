<?php
session_start();
define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');

$dawn=new Dawn();

$action=$dawn::get('a','');
if($action==''){
	die('Invalid visit');
}
$uid=$dawn::get('uid',-1);
$cate_id=$dawn::get('cate_id',0);

//当前用户名
$cur_uid=$_SESSION['uid'];
if($uid!=-1){
	$cur_uid=$uid;
}


switch ($action){
	case 'category':
		//返回目录
		$cate=Category::getByUserId($cur_uid);	
		echo json_encode($cate);
		break;
	case 'article':
		//返回文章列表
		$articles=Article::getList($cur_uid,$cate_id);	
		echo json_encode($articles);
		break;
}