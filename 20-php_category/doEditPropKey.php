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
}