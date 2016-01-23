<?php
session_start();
if(!isset($_SESSION['user']['uid'])){
	die('Invalid visit.');
}
$user=$_SESSION['user'];
$cur_uid=$_SESSION['user']['uid'];

include('dawnPHP/mylib.php');

//获取数据
$action=Dawn::get('a');
switch ($action){
	case 'del':
		$key_id=Dawn::get('key_id');
		$type=Dawn::get('type');
		$result=MyKey::del($cur_uid, $key_id,$type);
		echo json_encode($result);
		break;
	case 'add':
		$name=Dawn::get('name');
		$result = MyKey::add($cur_uid, $name);
		break;
		
	case 'send':
		$result=MyKey::update($_POST);
		if($result){
			echo "<script>alert('修改成功'); window.location='index.php'; </script>";
			exit();
		}else{
			echo '<a href="Location:editCate.php">点击返回</a>';
			echo '<hr>';
			die(mysql_error());
		}
		break;	
	
}