<?php
session_start();
define("BathPath",getcwd() . '/dawnPHP/');
include('dawnPHP/mylib.php');

$dawn=new Dawn();

$action=$dawn::get('a','');
if($action==''){
	die('Invalid visit');
}
$uid=$dawn::get('u_id',-1);
if($uid==-1){
	if(isset($_SESSION['uid'])){
		$uid=$_SESSION['uid'];
	}else{
		$uid=null;
	}
}
$cate_id=$dawn::get('cate_id',0);

//如果是退出，随时可以退出
if($action=='logout'){
	//退出干三件事：
	if($_SESSION['uid']){
		//1.清除数组中的会话信息
		$_SESSION['uid']=null;//或其他全局用户变量
		$_SESSION=array();//清空session
		
		//2.清除cookie
		setcookie(session_name(),false, time()-3600);
		
		//3.销毁服务器上的会话文件
		session_destroy();
	}
	
	//跳转回首页
	header("Location:index.php");
	exit();
}


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
	case 'detail':
		//返回文章详细信息
		$a_id=Dawn::get('a_id','');
		//判断是否为空
		
		$cate=Article::detail($uid,$a_id);	
		echo json_encode($cate);
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

		//插入数据库中
		echo Article::add($uid,$title,$content,$cate_id,$tags);
		break;
		
	case 'del':
		//删除文章
		$a_id=Dawn::get('a_id','');
		if($a_id==''){
			header("Location:index.php");
			exit();
		}
		//进行删除
		echo Article::delete($_SESSION['uid'],$a_id);
		break;
	case 'saveItem':
		//更新文章
		//debug($_POST);
		
		//新建数据
		$id=$dawn::post('id','');
		$title=$dawn::post('title','');
		$content=$dawn::post('content','');
		$cate_id=$dawn::post('cate_id',0);
		$tags=$dawn::post('tags','');
		$uid=$_SESSION['uid'];
		
		//更新数据库
		echo Article::save($id,$uid,$title,$content,$cate_id,$tags);
		break;
	default:
		echo 'error...';
		die();
}