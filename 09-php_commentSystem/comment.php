<?php	require('myLibDoor.php');	?>
<link rel='stylesheet' type="text/css" href="main.css">
<?php
/**
博客评论系统
1.带顶和踩的评论
http://geek.csdn.net/news/detail/38743
2.简单大方的评论
http://www.cnblogs.com/dwayne/archive/2012/07/06/MySQL_index_join_wayne.html

*/


//评论系统
echo '<div class=wrap>';
echo '<h1>待评论的博客、图片或商品</h1>';
echo '<p><b>v1.0.1</b><br>用ajax改写 删除评论。在级联删除多个dom时耗时较多：<br>
1.php通过ajax返回的序列化的数组在js中需要eval后使用。<br>
2.熟悉dom的删除操作。</p>

<p><b>v1.0.0</b><br>这是待评论的内容。该系统支持评论、对评论回复、对评论进行删除。一旦删除，会级联删除对该评论进行回复的所有评论。</p>';
$current_aid=1;//todo 数据获取get或session


	$uid=2; // 可以从session获取用户id

	//显示评论内容
	$arrGlobal=array('','');
	showAllComment($current_aid);
	$script = $arrGlobal[0];
	
	echo '<div id=comment>';
	echo '<div class=separator>以下是评论：</div>';
	echo $arrGlobal[1];
	echo '</div>';
	
	//输出评论id数据到js
	$script = '<script> aCommentList=[];'."\n\n".$script;
	$script .= '</script>';
	echo "\r\n".$script."\r\n";
?>

<div class=clear></div>

<pre id='notice'>Notice will go here</pre>

<a name='addComment'></a>
<form action='action.php?a=c_add' name='comment' method='post'>
	<span id='commentTo'></span>
	<br>
	昵称<input type=text name='nickName' value='Tom'/>
	<br>
	email<input type=email name='email' value='Tom@tom.com'/>
	<br>
	评论内容	<br>
	<textarea cols=50 rows=10 name='comment'>tom's comment</textarea>
		<br>
	<input type=submit name=submit value='submit'>
	
	<input type=hidden name=aid value=<?php echo $current_aid;?>>
	<input type=hidden name=uid value=<?php echo $uid;?>>
	<input type=hidden name=pid >
</form>

</div>
<div class=footer></div>


<script src='js/ajaxObjPrototype.js'></script>
<script src='js/nodeFn.js'></script>

<script>
//----------------------------------------------
// 工具函数 都放到库中了
//----------------------------------------------


//----------------------------------------------
//事件处理
//----------------------------------------------
window.onload=function(){
	var pid=0;
	var oForm=document.comment;
	
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

		//------------------------
		//把ajax放到form的submit事件中，巧妙的应用了提交事件。
		
		
		//------------------------
		//验证结束。开始ajax请求
		//------------------------
		//拼装参数
		var url='action.php?a=c_add&time='+(new Date()).getTime();
		var paras='nickName='+oForm.nickName.value;
		paras += '&email='+oForm.email.value;
		paras += '&comment='+oForm.comment.value;
		paras += '&pid='+oForm.pid.value;
		paras += '&aid='+oForm.aid.value;
		paras += '&uid='+oForm.uid.value;
		paras += '&submit=submit';//确定是post提交的
		//使用ajax请求
		var myAjax=new Ajax();

		myAjax.post(url, paras, function(str){
				$('notice').innerHTML='';
				$('notice').innerHTML += str + '<hr>';
					
				//使用eval处理字符，反序列化为json
				var oStr=eval('('+str+')');
				
				//根据条件创建新node
				var newObj=getCommentDomByAttri({
					'pid':oStr[2], 
					'id':oStr[3], 
					'uid':oForm.uid.value, 
					'time':oStr[4], 
					'content':oForm.comment.value,
					'nickName':oForm.nickName.value});

				//添加到dom树中
				if(oStr[2]==0){
					$('comment').appendChild(newObj)
				}else{
					appAfter( newObj, $('comment_id_'+oStr[2]) );
				}
				
			}, function(str){
				$('notice').innerHTML = 'Error1: '+str;
			});
		//ajax已经提交，表单就不应该再提交了。
		
		return false;
	}
	
	//alert(aCommentList);
	//comment_id_
	
	//为删除 和 回复 按钮绑定事件
	for(var i in aCommentList){
		//var oComment=[],aBtns=[],oBtnDel=[],oBtnReply=[]
		oComment=$('comment_id_'+aCommentList[i]);
		aBtns=oComment.getElementsByTagName('span');
		oBtnDel=aBtns[0];		oBtnDel.id=aCommentList[i];
		oBtnReply=aBtns[1];		oBtnReply.id=aCommentList[i];
		
		
		//为 删除按钮 绑定事件
		oBtnDel.onclick=function(){
			deleteFn(this);
		}
		//为 回复按钮 绑定事件
		oBtnReply.onclick=function(){
			replyFn(this);
		}
	}
	
	
	
	/*
		删除按钮的事件函数
	*/
	function deleteFn(_this){
		if(confirm('你确定要删除#'+_this.id+'楼的留言吗？(包括此后的回复)')){
		//window.location='action.php?a=c_del&cid=' + _this.id;
		
		
		//ajax请求
		var ajax=new Ajax();
		//url='action.php?a=c_del&cid=' + _this.id +'&t='+(new Date()).getTime();
		url='action.php?a=c_del&cid=' + _this.id;
		
		ajax.get(url, function(text){
				//ajax成功后的处理
				var arr = eval('(' + text + ')');
				
				//删除成功后
				if(1==arr[0]){
					$('notice').innerHTML=arr
					//$('notice').innerHTML=arr[1]
					var arr2=arr[2]
					//删除节点
					for(var i=0; i<arr2.length; i++){
						removeDom( $('comment_id_'+arr2[i]) )
					}
				}else{
					//删除失败后
					$('notice').innerHTML="<span style='color:red'>"+arr[1]+'</span>'
				}
			}, function(text){
				//ajax失败后的处理
				$('notice').innerHTML=text
			});
		}
	}
	/*
		回复按钮的事件函数
	*/
	function replyFn(_this){
		//定位到评论框
		window.location='#addComment';
		//给定父评论的id
		pid=_this.id;
		
		//提示正在回复第几楼
		$('commentTo').innerHTML='回复#'+ pid + '楼: ';
	}
	
	/*
	* 根据strObj描述信息返回新的评论的dom元素
	*/
	function getCommentDomByAttri(strObj){
		//解析出描述对象的属性
		var id=strObj['id'];
		var nickName=strObj['nickName'];
		var content=strObj['content'];
		var uid=strObj['uid'];
		var pid=strObj['pid'];
		var time=strObj['time'];
		
		//control标签
		var oDivCtrl=createNode('div',{'class':'control'});
		var oSpan1=createNode('span',{'id':id},'删除');
		var oSpan2=createNode('span',{'id':id},'回复');
		
		oDivCtrl.appendChild(oSpan1); 
		oDivCtrl.appendChild(document.createTextNode(' ')); 
		oDivCtrl.appendChild(oSpan2); 

		//此处添加事件 删除和回复
		//为 删除按钮 绑定事件
		oSpan1.onclick=function(){
			deleteFn(this);
		}
		//为 回复按钮 绑定事件
		oSpan2.onclick=function(){
			replyFn(this);
		}
		
		//创建最外层div
		var newStyleClass=pid==0?'comment':'comment sub'
		var newObj=createNode('div',{'class':newStyleClass, 'id': ('comment_id_'+id) })
		newObj.appendChild(oDivCtrl)
		//添加文字
		var oP=createNode('p',{},' [#'+id+'楼]');
		//在p中添加a标签
		var oA=createNode('a', {'href':'usr.php?uid='+(oForm.uid.value)}, nickName);
		oP.appendChild(oA)
		//添加文字
		oP.appendChild(document.createTextNode(time+':'))
		//添加到最外层中
		newObj.appendChild(oP)
		
		//添加文字：评论内容
		newObj.appendChild(document.createTextNode(content))
		return newObj;
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