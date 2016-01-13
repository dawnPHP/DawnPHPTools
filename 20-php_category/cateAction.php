<?php
session_start();
define("BathPath",getcwd() . '/dawnPHP/');
include('dawnPHP/mylib.php');

//获取操作名
$action=Dawn::get('a','');
if($action==''){
	die('Invalid visit!');
}

//获取用户id
$uid=Dawn::get('u_id',-1);
if($uid==-1){
	if(isset($_SESSION['user']['uid'])){
		$uid=$_SESSION['user']['uid'];
	}else{
		$uid=null;
	}
}

//获取目录id
$cate_id=Dawn::get('cate_id',0);

//登陆
if($action=='login'){
	//debug($_POST);

	$user=User::login(Dawn::post('usr'), Dawn::post('psw'));
	if(count($user)>0){
		$_SESSION['user']=$user;
		echo '登陆成功。';
		//跳转回首页
		header("Location:index.php");
		exit();
	}else{
		echo '登陆失败！';
	}
	
	//跳转回首页
	echo '<a href="index.php">返回首页</a>';
	exit();
}

//如果是退出，随时可以退出
if($action=='logout'){
	//退出干三件事：
	if($_SESSION['user']){
		//1.清除数组中的会话信息
		$uer=null;//或其他全局用户变量
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

//如果没登录，不能进行后续操作
if(!isset($_SESSION['user']['uid'])){die('Invalid visit!');}

//当前用户名
$cur_uid=$_SESSION['user']['uid'];


//这一条去掉，不知道影响多少？
if($uid!=-1){
	//$cur_uid=$uid;
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
		// 补充属性信息
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
		$title=Dawn::post('title','');
		$content=Dawn::post('content','');
		$cate_id=Dawn::post('cate_id',0);
		$tags=Dawn::post('tags','');

		//作出判断，排除空值

		//插入数据库中
		echo Article::add($cur_uid,$title,$content,$cate_id,$tags);
		break;
		
	case 'del':
		//删除文章
		$a_id=Dawn::get('a_id','');
		if($a_id==''){
			header("Location:index.php");
			exit();
		}
		//进行删除
		echo Article::delete($cur_uid,$a_id);
		break;
	case 'saveItem':
		//更新文章
		//debug($_POST);
		
		//新建数据
		$id=Dawn::post('id','');
		$title=Dawn::post('title','');
		$content=Dawn::post('content','');
		$cate_id=Dawn::post('cate_id',0);
		$tags=Dawn::post('tags','');
		
		//更新数据库
		echo Article::save($id,$cur_uid,$title,$content,$cate_id,$tags);
		break;
	default:
		echo 'error...';
		die();
}