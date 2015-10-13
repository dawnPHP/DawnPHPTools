<?php
//引入入口文件
include('common/myLibDoor.php');


	$action=getGetValue('a');
	//if($action=='') die('Invalid url.');
	
//处理动作
switch($action){
	case 'c_del'://评论-删除
		//获取数据
		$cid=getGetValue('cid');
	
		//执行删除
		//如果不指定id，则返回错误
		if($cid=='') {
			$msg=array(0, '删除了0条数据');
			//返回json
			echo json_encode($msg);
			//die('invalid deletion.');
		}
		
		//递归删除所有子回复
		$total_deletedIDs=delAllCommentAfter($cid);
		$total_deleted=count($total_deletedIDs);
		
		//设定返回值
		if($total_deleted>0){
			//成功
			$msg=array(1,'成功删除了'.$total_deleted.'条评论');
		}else{
			$msg=array(0, '删除了0条数据');
		}
		$msg[]=$total_deletedIDs;
		$a=array(1,'1234');
		//返回json
		echo json_encode($msg);
		//echo '成功删除了'.$total_deleted.'条评论.';
		//echo '<script>window.history.back(-1);</script>';
		
		//返回上一页(todo del:使用ajax之后，就不用返回这么多了。)
		//echo '<script>/*等待3s返回上一页并刷新*/		setTimeout(function(){window.location.href = document.referrer;}, 3000);</script>';
		break;
		
	case 'c_add':
		//插入数据库	
		if(isset($_POST['submit'])){
			$aid=getPostValue('aid');//文章ID
			$pid=getPostValue('pid',0);//父评论的ID
			$comment=getPostValue('comment');
			$uid=getPostValue('uid');
			$nickName=getPostValue('nickName');
			$email=getPostValue('email');

			$comment_time=time();

			$sql="insert into $commentTbl(aid,pid, comment, uid, nickName, email, comment_time) 
			values({$aid},{$pid},'{$comment}',{$uid},'{$nickName}','{$email}',{$comment_time});";

			mysql_query($sql) or die('insert Err: '.mysql_error());
		
			//设定返回值
			$msg=array(1);//成功
			$msg[]='添加成功'. mysql_affected_rows() .'行';//添加成功
			$msg[]=$pid;//返回添加条目父id:pid
			
				$lastID=mysql_query("select max(id) as lastID from $commentTbl;") or die('select Erro: '.mysql_error());
				$lastID=mysql_fetch_assoc($lastID);
			$msg[]=$lastID['lastID'];//返回添加条目的id 怎么用？SELECT LAST_INSERT_ID()
			
			$msg[]=date('Y-m-d h:i:s', $comment_time);//返回添加时间
		}else{
			$msg=array(0);//成功
			$msg[]='添加失败';//添加成功
			die('invalid url.');
		}
		
		//$msg['post']=$_POST;//返回全部数据，供参考
		//返回json
		echo json_encode($msg);
		
		break;
	case 'insert':
		echo 'insert';
		break;
	case 'insert22':
		echo 'insert22';
		break;
	default:
		echo 'other';
}