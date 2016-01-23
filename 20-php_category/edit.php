<?php
session_start();
if(!isset($_SESSION['user']['uid'])){
	die('Invalid visit.');
}
$user=$_SESSION['user'];
$uid=$_SESSION['user']['uid'];

include('dawnPHP/mylib.php');

//获取uid
$a_id=Dawn::get('a_id',null);
if($a_id==null){
	Dawn::died();
}

//获取数据
$cate=Article::detail($uid,$a_id);
$data=$cate[0];

include 'View/header.php';
include 'View/Index/edit.html';
include('View/footer.php');
?>