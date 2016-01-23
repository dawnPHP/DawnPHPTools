<?php
session_start();
if(!isset($_SESSION['user'])){
	die('Invalid visit.');
}
$user=$_SESSION['user'];
$uid=$_SESSION['user']['uid'];

include('dawnPHP/mylib.php');

//获取数据
$sql='select id,name,u_rank from category where u_id='.$uid . ' order by u_rank';
$rows=mysql_query($sql,$GLOBALS['DB']);


include 'View/header.php';
include('View/edit/editCate.html');
include('View/footer.php');
?>