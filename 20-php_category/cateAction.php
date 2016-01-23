<?php
session_start();

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
	//$uid=$cur_uid;
}


switch ($action){
	case 'category':
		//返回目录
		$cate=Category::getByUserId($uid);	
		echo json_encode($cate);
		break;
	case 'artilist'://article list
		//返回文章列表
		$articles=Article::getList($uid,$cate_id);	
		echo json_encode($articles);
		break;
	case 'detail':
		//返回文章详细信息 
		$a_id=Dawn::get('a_id','');
		//判断是否为空
		
		//文章基本信息
		$cate=Article::detail($uid,$a_id);	
		// 要补充属性信息
		$prop=Property::detail($uid,$a_id);
		$cate['prop']=$prop;
		//返回结果
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
		
		//新建数据
		$id=Dawn::post('id','');
		$title=Dawn::post('title','');
		$content=Dawn::post('content','');
		$cate_id=Dawn::post('cate_id',0);
		$tags=Dawn::post('tags','');
		
		//更新数据库
		echo Article::save($id,$cur_uid,$title,$content,$cate_id,$tags);
		break;
	case 'newValue':
		//添加新属性值
		//获取参数
		$a_id=Dawn::post('a_id','');
		$key_id=Dawn::post('key_id','');
		$text=Dawn::post('text','');
		$type=Dawn::post('type','');//如果是文件，需要上传
		//Warning: POST Content-Length of 10975023 bytes exceeds the limit of 8388608 bytes in Unknown on line 0
		//http://stackoverflow.com/questions/6279897/post-content-length-exceeds-the-limit
		//http://www.360doc.com/content/13/1210/11/14452132_336027836.shtml

		//执行文件上传
		$path='upload/usr_'.$cur_uid. '/'. $a_id;
		if($type==1){//图片上传
			//文件的限制条件
			$restricts=array(
				'size'=>2000, //unit: kb
				'type'=>array("image/gif", "image/jpeg", "image/pjpeg", "image/png")
			);

			//实例化上传对象
			$upload1=new UploadFile($_FILES['text']);
			$upload1->set_restricts($restricts);
			//执行上传
			$arr = $upload1->upload_to($path, false);
			if($arr[0]==0){
				//Dawn::died('上传出现错误！' . $arr[1]);
				Dawn::goBackIn(5,'','上传出现错误！' . $arr[1]);
			}else{
				$text=$arr[1];
			}
		}elseif($type==2){//文件上传
			//文件的限制条件
			$restricts=array(
				'size'=>4000, //unit: kb
				'type'=>array('application/pdf',
					'application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document',
					'application/vnd.ms-powerpoint','application/vnd.openxmlformats-officedocument.presentationml.presentation',
					'application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
					'text/plain','application/octet-stream')
			);
			//doc/docx/xls/xlsx/ppt/pptx/zip/rar

			//实例化上传对象
			$upload1=new UploadFile($_FILES['text']);
			$upload1->set_restricts($restricts);
			//执行上传
			$arr = $upload1->upload_to($path, false);
			if($arr[0]==0){
				Dawn::goBackIn(5,'','上传出现错误！' . $arr[1]);
			}else{
				$text=$arr[1];
			}
		}
		
		//添加属性值
		$result=MyValue::add($cur_uid, $a_id, $key_id, $text);
		if(!$result){
			Dawn::died('添加属性失败。');
		}
		Dawn::back();
		
		break;
	case 'delValue'://删除属性值
		//新建数据
		$id=Dawn::get('id','');
		$type=Dawn::get('type','');
		//删除数据
		$result=MyValue::del($cur_uid, $id, $type);
		echo json_encode($result);
		
		break;
	default:
		echo '<h1>oops！</h1>Something Error ...';
		die();
}

/*
//debug($_FILES);
//rtf application/msword

//doc 	application/msword
//docx application/vnd.openxmlformats-officedocument.wordprocessingml.document

//ppt 	application/vnd.ms-powerpoint
//pptx application/vnd.openxmlformats-officedocument.presentationml.presentation

//xls 	application/vnd.ms-excel
//xlsx	application/vnd.openxmlformats-officedocument.spreadsheetml.sheet

//txt text/plain
//html 	text/html
//pdf/md/seq/zip/rar application/octet-stream
*/