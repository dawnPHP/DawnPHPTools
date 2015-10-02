<?php
/**
博客评论系统
1.带顶和踩的评论
http://geek.csdn.net/news/detail/38743
2.简单大方的评论
http://www.cnblogs.com/dwayne/archive/2012/07/06/MySQL_index_join_wayne.html





*/

//引入自定义函数库
include('Temp_function.php');
//连接数据库
if(!isset($conn)){
	include('conn.php');
}


//设置时区
//date_default_timezone_set('PRC');
date_default_timezone_set('Asia/Shanghai');

//评论系统
echo '<div id=comment>';
echo '<h1>这是待评论的博客、图片或商品</h1>';
echo '<p>这是待评论的内容。该系统支持评论、对评论回复、对评论进行删除。一旦删除，会级联删除对该评论进行回复的所有评论。</p>';
$current_aid=1;//todo 数据获取get或session


	$uid=2; // 可以从session获取用户id

//显示评论内容
	$arrGlobal=array('','');
	showAllComment($current_aid);
	$script = $arrGlobal[0];
	
	echo '<div class=separator>以下是评论：</div>';
	echo $arrGlobal[1];
	
	//输出评论id数据到js
	$script = '<script> aCommentList=[];'."\n\n".$script;
	$script .= '</script>';
	echo "\r\n".$script."\r\n";	
?>

<div class=clear></div>

<a name='addComment'></a>
<form action='action.php?a=c_add' name='comment' method='post'>
	<span id=commentTo></span>
	<br>
	昵称<input type=text name='nickName' />
	<br>
	email<input type=email name='email' />
	<br>
	评论内容	<br>
	<textarea cols=50 rows=10 name='comment'></textarea>
		<br>
	<input type=submit name=submit value='submit'>
	
	<input type=hidden name=aid value=<?php echo $current_aid;?>>
	<input type=hidden name=uid value=<?php echo $uid;?>>
	<input type=hidden name=pid >
</form>

</div>
<div class=footer></div>

<style>
div, p{margin:0; padding:0;}
.clear{clear:both; height:10px;width:100%;}


#comment{width:500px; margin:0 auto;}
#comment .separator{
	font-family:'微软雅黑';
	margin:20px 0; background-color:#0096ff; 
	padding:5px 10px; color:#fff;
	width:100%; border-top:1px dashed #0096ff;}
#comment a{color:#0096ff;}
.comment{background:#fefefe; padding:5px; margin:5px; 
    font-family: monospace;
	border-left:2px solid #0096ff; 
	border-bottom:1px dashed #aaa;  clear:both;

	word-wrap: break-word;
　　/*word-break设置强行换行;
		normal 	亚洲语言和非亚洲语言的文本规则，允许在字内换行*/
　　word-break: normal;		
}
.sub{margin-left:50px;}
form{padding:10px 30px; border:2px solid #fafafa;}
form:hover{background:#fafafa; border:2px solid #0096ff;}

.comment:hover{ background:#F8F9FB;}
.comment p, .comment .control{color:#aaa;}
.comment a{text-decoration:none;}

.comment .control{float:right;}
.comment .control span{ cursor: pointer;}
.comment .control span:hover{background-color:#BE3948; color:white;}

input{margin:10px;}


.footer{height:200px;}
</style>

<script>
//根据id获取obj
function $(s){
	if(typeof s=='object') return s;
	return document.getElementById(s);
}

//载入事件
window.onload=function(){
	var pid=0;
	//var oForm=document.getElementById('comment');
	var oForm=document.comment;
	//alert(oForm.nickName.value=='')
	
	//提交前的验证
	oForm.onsubmit=function(){
		if(''==oForm.nickName.value){
			alert('昵称不能为空'); 
			return false;
		};
		if(''==oForm.email.value){
			alert('邮箱不能为空');
			return false;
		};
		if(''==oForm.comment.value){
			alert('评论不能为空'); return false;
		};
		//pid就是该评论的父评论
		oForm.pid.value=pid;

		return true;
	}
	
	//alert(aCommentList);
	//comment_id_
	
	//为删除 和 回复 按钮绑定事件
	for(var i in aCommentList){
		oComment=$('comment_id_'+aCommentList[i]);
		aBtns=oComment.getElementsByTagName('span');
		oBtnDel=aBtns[0];		oBtnDel.id=aCommentList[i];
		oBtnReply=aBtns[1];		oBtnReply.id=aCommentList[i];
		
		
		//为 删除按钮 绑定事件
		oBtnDel.onclick=function(){
			if(confirm('你确定要删除#'+this.id+'楼的留言吗？(包括此后的回复)')){
				window.location='action.php?a=c_del&cid=' + this.id;
			}
		}
		//为 回复按钮 绑定事件
		oBtnReply.onclick=function(){
			//定位到评论框
			window.location='#addComment';
			//给定父评论的id
			pid=this.id;
			
			//提示正在回复第几楼
			$('commentTo').innerHTML='回复#'+ pid + '楼: ';
		}
	}
	
	
	
}

</script>


<?php
/**
评论表: comment
id——自动生成，评论的ID
aid——文章的id
pid——父评论的id
comment——品论内容

uid——评论人的用户编号

nickName--评论人的昵称
email--评论人的email
comment_time--评论时间

--
-- 表的结构 `comment`
--
CREATE TABLE IF NOT EXISTS `comment`(
	id int(10) auto_increment not null primary key,
	aid int(10),
	pid int(10) default 0,
	comment text,
	uid int(10),
	nickName varchar(30),
	email varchar(30),
	comment_time varchar(30)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--添加索引
ALTER TABLE comment ADD INDEX aid (aid);  
ALTER TABLE comment ADD INDEX uid (uid);  

mysql> desc comment;
+--------------+-------------+------+-----+---------+----------------+
| Field        | Type        | Null | Key | Default | Extra          |
+--------------+-------------+------+-----+---------+----------------+
| id           | int(10)     | NO   | PRI | NULL    | auto_increment |
| aid          | int(10)     | YES  | MUL | NULL    |                |
| pid          | int(10)     | YES  |     | 0       |                |
| comment      | text        | YES  |     | NULL    |                |
| uid          | int(10)     | YES  | MUL | NULL    |                |
| nickName     | varchar(30) | YES  |     | NULL    |                |
| email        | varchar(30) | YES  |     | NULL    |                |
| comment_time | varchar(30) | YES  |     | NULL    |                |
+--------------+-------------+------+-----+---------+----------------+
8 rows in set (0.01 sec)

*/