<?php
//function lib v1.0.0

/**
* 获取post数据，过滤并输出供mysql使用
*/
function getPostValue($name,$defaultValue=''){
	$temp=isset($_POST[$name])?$_POST[$name]:$defaultValue;
	return mysql_real_escape_string($temp);
}

/**
* 获取post数据，过滤并输出供mysql使用
*/
function getGetValue($name,$defaultValue=''){
	$temp=isset($_GET[$name])?$_GET[$name]:$defaultValue;
	return mysql_real_escape_string($temp);
}

/**
* 递归删除所有子回复
*/
//function delAllCommentAfter($cid,&$deletedIDs){
function delAllCommentAfter($cid,$deletedIDs=array()){
	global $commentTbl;
	//删除当前id号的帖子
	$sql="delete from $commentTbl where id={$cid}";
	mysql_query($sql) or die('delete Err: '.mysql_error());

	//记录删除条目
	$deletedIDs[]= $cid;
	
	//查找当前id号为父id的帖子
	$sql="select id from $commentTbl where pid={$cid}";
	$rows=mysql_query($sql) or die('select Err: '.mysql_error());
	
	//如果找到，则递归删除
	if(mysql_num_rows($rows)>0){
		$row=mysql_fetch_assoc($rows);
		//echo '本次删除条目数：'.$deletedIDs.'<br />';
		return delAllCommentAfter($row['id'], $deletedIDs);
	}else{
		return $deletedIDs;
	}
}




/**
* 显示所有评论
* 递归查询所有的评论的函数
* version:1.0.1
*/
function getAllComments($current_aid, $pid=0,$lastCID=0){
	//使用全局数组
	global $arrGlobal;
	global $commentTbl;
	
	$sql="select * from {$commentTbl} where aid={$current_aid} and pid={$pid} order by comment_time;";

	$rows=mysql_query($sql) or die('select Err: '.mysql_error());
		
	//如果没有查找到，则递归返回
	if(mysql_affected_rows()<=0){
		return $arrGlobal;
	}
	
	//开始查找评论
	//进入循环
	while($row=mysql_fetch_assoc($rows)){
		$script ='';   /*为js提供数据*/
		$commentContent=''; /*为了html显示评论*/
		
		$id=$row['id'];
		$aid=$row['aid'];
		$uid=$row['uid'];
		$nickName=$row['nickName'];
		$email=$row['email'];
		$comment=$row['comment'];
		$comment_time=$row['comment_time'];
		
		//一些判断
		//显示的评论的id号
		$script .= 'aCommentList.push(' . $id . ');'  . "\n";
		//博主的判断
		$status='';//怎么判断是不是博主呢？依靠session吧
		//仿照 http://www.cnblogs.com/dwayne/archive/2012/07/06/MySQL_index_join_wayne.html
		
		//根据评论的级别添加样式
		$styleClass=($pid==0?'comment':'comment sub');
		
		$commentContent .= '<div class="'.$styleClass.'" id="comment_id_'.$id.'">';
		
		$commentContent .= '<div class=control><span>删除</span> <span>回复</span></div>';
		
		//判断是否是评论：
		if($lastCID!=0){
			$replyTo = '回复';
			$last_uid = getFiledById($lastCID, 'uid');
			$replyTo .='<a href="user.php?uid='.$last_uid.'">'. getFiledById($lastCID, 'nickName') . '</a> ';
		}else{
			$replyTo ='';
		}
		
		$commentContent .= '<p>[#'.$id.'楼]<a href="usr.php?uid='.$uid.'">'.$nickName.$status.'</a>'.$replyTo.date('Y-m-d h:i:s', $comment_time);
		
		//$commentContent .= ' <a href="mailto:'.$email.'">Email</a>';
		//$time=date( 'Y-m-d H:i:s',$row['time']);
		$commentContent .= ':</p>';
		
		$commentContent .= $comment;
		$commentContent .= '</div>'  . "\n\n";
		
		//鼠标悬停，出现 回复 投诉按钮 http://geek.csdn.net/news/detail/38743
		
		//递归调用
		$arrGlobal[0] .= $script;
		$arrGlobal[1] .= $commentContent;
		
		getAllComments($current_aid,$id,$id);
	}
}


/**
* 通过id获取某字段名（comment表中）
*/
function getFiledById($id, $column){
	global $commentTbl;
	//连接数据库
	if(!isset($conn)){include('conn.php');}
	
	//查询
	$rows=mysql_query("select {$column} from $commentTbl where id={$id};") or die('select Err: '. mysql_error() );
	if(mysql_num_rows($rows)<0){
		die('Nothing returned.');
	};
	$row=mysql_fetch_assoc($rows);
	return $row[$column];
}