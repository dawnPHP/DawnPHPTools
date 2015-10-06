<?php	require('common/myLibDoor.php');	
echo '<link rel="stylesheet" type="text/css" href="'. $publicPath .'css/main.css">';

/**
评论系统20151006
1.带顶和踩的评论
http://geek.csdn.net/news/detail/38743
2.简单大方的评论
http://www.cnblogs.com/dwayne/archive/2012/07/06/MySQL_index_join_wayne.html
*/

//============================
//	显示博客
//============================
echo '<div class=wrap>';
echo '<h1>待评论的博客、图片或商品</h1>';
echo '<p><b>v1.0.2</b><br>
用ajax改写 添加 评论。在动态添加dom时耗时较多：<br>
1.为了使用ajax post，重新写了ajax的prototype形式。<br>
2.熟悉dom的添加操作。<br>
	小心：添加第一条评论时可能会失败。<br>
3.已经修改#comment的范围，仅仅是评论区域。<br>
4.抽离了css和js到一个文件中；<br>
  抽离了时区设置、编码、数据库连接到一个入口php文件。<br>
  <b class=bug>bug001: 当对同一个评论回复超过2次时，第二个不会被删除！</b>
</p><br>

<p><b>v1.0.1</b><br>用ajax改写 删除评论。在级联删除多个dom时耗时较多：<br>
1.php通过ajax返回的序列化的数组在js中需要eval后使用。<br>
2.熟悉dom的删除操作。</p><br>

<p><b>v1.0.0</b><br>这是待评论的内容。该系统支持评论、对评论回复、对评论进行删除。一旦删除，会级联删除对该评论进行回复的所有评论。</p>';

//============================
//	显示评论
//============================
	$current_aid=1;//todo 数据获取get或session
	$uid=2; // 可以从session获取用户id

	//获取评论数据
	$arrGlobal=array('','');
	getAllComments($current_aid);
	$script = $arrGlobal[0];//给js传递删除条目
	
	echo '<div class=title>以下是评论：</div>';
	echo '<div id=comment>';
	echo $arrGlobal[1];
	echo '</div>';
	
	//输出评论id数据到js
	$script = '<script> aCommentList=[];'."\n\n".$script;
	$script .= '</script>';
	echo "\r\n".$script."\r\n";
?>

<div class=clear></div>
<pre id='notice'>Notice will go here</pre>

<!--
//============================
//	添加评论的表单
//============================
-->
<form name='comment'>
	<a name='addComment'></a>
	<span id='commentTo'></span>
	<br>
	昵称<input type=text name='nickName' value='Tom'/>
	<br>
	email<input type=email name='email' value='Tom@tom.com'/>
	<br>
	评论内容	<br>
	<textarea cols=85 rows=10 name='comment'>tom's comment中文评论</textarea>
		<br>
	<input type=submit name=submit value='submit'>
	
	<input type=hidden name=aid value=<?php echo $current_aid;?>>
	<input type=hidden name=uid value=<?php echo $uid;?>>
	<input type=hidden name=pid >
</form>

</div>
<div class=footer></div>


<script src='<?php echo $publicPath;?>js/ajaxObjPrototype.js'></script>
<script src='<?php echo $publicPath;?>js/nodeFn.js'></script>

<script>
//----------------------------------------------
// 工具函数 都放到库中了
//----------------------------------------------


//----------------------------------------------
// 事件处理
//----------------------------------------------
window.onload=function(){
	var pid=0;
	var oForm=document.comment;
	
	//提交前的验证
	oForm.onsubmit=function(){
		if(''==oForm.nickName.value){
			alert('昵称不能为空'); return false;
		};
		if(''==oForm.email.value){
			alert('邮箱不能为空'); return false;
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
	
	
	/*
	*   为删除 和 回复 按钮绑定事件
	*/
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
	*	删除按钮的事件函数
	*/
	function deleteFn(_this){
		if(confirm('你确定要删除#'+_this.id+'楼的留言吗？(包括此后的回复)')){
		
		//ajax请求
		url='action.php?a=c_del&cid=' + _this.id;
		var ajax=new Ajax();
		ajax.get(url, function(text){
				//ajax成功后的处理
				var arr = eval('(' + text + ')');
				
				//后台数据删除成功后
				if(1==arr[0]){
					$('notice').innerHTML=arr
					//$('notice').innerHTML=arr[1]
					var arr2=arr[2]
					//删除节点
					for(var i=0; i<arr2.length; i++){
						removeDom( $('comment_id_'+arr2[i]) )
					}
				}else{
					//后台数据删除失败后
					$('notice').innerHTML="<span style='color:red'>"+arr[1]+'</span>'
				}
			}, function(text){
				//ajax失败后的处理
				$('notice').innerHTML=text
			});
		}
	}
	
	
	/*
	*	回复按钮的事件函数
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
		oP.appendChild(oA);
		//添加文字
		oP.appendChild(document.createTextNode(time+':'));
		//添加到最外层中
		newObj.appendChild(oP);
		
		//添加文字：评论内容
		newObj.appendChild(document.createTextNode(content));
		return newObj;
	}
}

</script>
