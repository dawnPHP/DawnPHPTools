<?php
session_start();
if(!isset($_SESSION['user']['uid'])){
	die('Invalid visit.');
}
$user=$_SESSION['user'];
$uid=$_SESSION['user']['uid'];

include('dawnPHP/mylib.php');

//获取数据
$action=Dawn::get('a');
switch ($action){
	case 'del':
		$cate_id=Dawn::get('cate_id');
		$result=Category::delete($cate_id,$uid);
		if($result){
			echo "<script>alert('删除成功');
			window.location='editCate.php';
			</script>";
			//header("Location:editCate.php");
			exit();
		}else{
			echo '<a href="Location:editCate.php">点击返回</a>';
			echo '<hr>';
			die(mysql_error());
		}
		break;
	case 'add':
		$name=Dawn::get('name');
		$result = Category::add($name,$uid);
		if($result){
			echo "<script>alert('添加成功！');
			window.location='editCate.php';
			</script>";
			exit();
		}else{
			echo '<a href="Location:editCate.php">点击返回</a>';
			echo '<hr>';
			die(mysql_error());
		}
		
		break;
	case 'send':
		$result=Category::update($_POST);
		if($result){
			echo "<script>alert('修改成功');
			window.location='index.php';
			</script>";
			exit();
		}else{
			echo '<a href="Location:editCate.php">点击返回</a>';
			echo '<hr>';
			die(mysql_error());
		}
		break;
	
}
//echo '<pre>';
//print_r($_POST);
?>