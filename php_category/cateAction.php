<?php
session_start();
define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');

$dawn=new Dawn();

$action=$dawn::get('a','');
if($action==''){
	die('Invalid visit');
}
$uid=$dawn::get('u_id',-1);
if($uid==-1){
	$uid=$_SESSION['uid'];
}
$cate_id=$dawn::get('cate_id',0);

if(!isset($_SESSION['uid'])){die('Invalid visit!');}
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
	case 'artilist'://article list
		//返回文章列表
		$articles=Article::getList($cur_uid,$cate_id);	
		echo json_encode($articles);
		break;
	case 'change_cate':
		//debug($_POST);
		//要改变目录的条目id数组
		echo Article::change_cate($_POST);
		break;
	case 'newItem':
		//debug($_POST);
		//新建条目
		$title=$dawn::post('title','');
		$content=$dawn::post('content','');
		$cate_id=$dawn::post('cate_id',0);
		$tags=$dawn::post('tags','');
		$uid=$_SESSION['uid'];
		//作出判断，排除空值
		
		//进行插入
		$result = Article::add($uid,$title,$content,$cate_id,$tags);
		if($result){
			header("Location:index.php");
			exit();
		}else{
			echo mysql_error() . '<hr>';
			die('<a href="index.php">回到首页</a>');
		}
		break;
		
}