<?php
session_start();
if(!isset($_SESSION['user']['uid'])){
	die('Invalid visit!');
}
$user=$_SESSION['user'];
$uid=$_SESSION['user']['uid'];


include('dawnPHP/mylib.php');

//获取条目详细数据
$a_id=Dawn::get('a_id',null);
if($a_id==null){
	die('Invalid visit!');
}



include 'View/header.php';
include 'View/Index/detail.html';
include('View/footer.php');
?>