<?php
//引入自定义函数库
include('Temp_function.php');
//连接数据库
	if(!isset($conn)){
		include('conn.php');
	}

	$action=getGetValue('a');
	if($action=='') die('invalid url.');
	
//处理动作
switch($action){
	case 'c_del'://评论-删除
		//获取数据
		$cid=getGetValue('cid');
	
		//执行删除
		//如果不指定id，则返回错误
		if($cid=='') {
			echo '<a href="post.php">点击返回</a>';
			die('invalid deletion.');
		}
		//递归删除所有子回复
	//	$sql="delete from comment where id={$cid} or pid={$cid}";
//
//		mysql_query($sql) or die('delete Err: '.mysql_error());
		$total_deleted=delAllCommentAfter($cid);
		echo '成功删除了'.$total_deleted.'条评论.<hr>';
		//echo '<script>window.history.back(-1);</script>';
		
		//返回上一页
		echo '<script>/*等待3s返回上一页并刷新*/
		setTimeout(function(){window.location.href = document.referrer;}, 3000);</script>';
		break;
		
	case 'c_add':
		echo 'c_add';
		//	echo '<pre>';print_r($_GET);	print_r($_POST); die();//todo
		//插入数据库	
		if(isset($_POST['submit'])){
			$aid=getPostValue('aid');//文章ID
			$pid=getPostValue('pid',0);//父评论的ID
			$comment=getPostValue('comment');
			$uid=getPostValue('uid');
			$nickName=getPostValue('nickName');
			$email=getPostValue('email');

			$comment_time=time();

			$sql="insert into comment(aid,pid, comment, uid, nickName, email, comment_time) 
			values({$aid},{$pid},'{$comment}',{$uid},'{$nickName}','{$email}',{$comment_time});";

			mysql_query($sql) or die('insert Err: '.mysql_error());
			echo '插入'.mysql_affected_rows().'行<hr>';
		}else{
			die('invalid url.');
		}
		
		//返回上一页
		echo '<script>window.location.href = document.referrer;//返回上一页并刷新</script>';
		
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




