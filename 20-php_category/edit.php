<?php
session_start();
if(!isset($_SESSION['uid'])){
	die('Invalid visit.');
}
$uid=$_SESSION['uid'];

define("BathPath",getcwd() . '/dawnPHP/');
include('dawnPHP/mylib.php');

//获取uid
$a_id=Dawn::get('a_id',null);
if($a_id==null){
	Dawn::died();
}

//获取数据
$cate=Article::detail($uid,$a_id);
$data=$cate[0];
//debug($data);
?>
<html>
<head>
<link rel="stylesheet" href="public/css/category.css" />
<link rel="stylesheet" href="public/css/edit.css" />
<script src='public/js/ajaxObjPrototype.js'></script>
<script src='public/js/dom.js'></script>
</head>

<body>
<div class='header'>
	<h1>编辑&gt;编辑条目</h1>
		<a href='index.php'><input type='button' class=btn value='&lt;&lt;返回首页' /></a>
<pre>
[1]index.php?cate_id=-1&u_id=2 所有条目
[2]index.php?cate_id=0&u_id=2 默认分类
[3no] index.php?cate_id=-2&u_id=2 回收站
</pre>
</div>

<div class=main>
	
	<div class=new id='new'>
		<form method='post' action='cateAction.php?a=saveItem'>
			<input type=hidden name=a_id value=<?php echo $data['id'];?> />
		<div class=title>
			<input type=text name=title placeholder="请输入标题" value='<?php echo $data['title'];?>' />
		</div>
		<div class=content>
			<textarea rows="4" name='content' cols="134" placeholder="请在此处介绍自己..."><?php echo $data['content'];?></textarea>
		</div>
		<div class=cate>
			请选择分类：
			<select name='cate_id' id='cateList' >
				<option value=0>默认分类</option>
			</select>
		</div>
		<div class=tags>
			请添加标签：
			<input type='text' placeholder='该功能还在开发中' name='tags' class='tags' />
			
		</div>
		<div class=submit>
			<input type='button' id='send'  class='btn blue' value='提交'>
			<span id='hint'>提示文字</span>
		</div>
		
		<hr>
		<a href='index.php'><input type='button' class='btn' value='&lt;&lt;返回首页(放弃修改)' /></a>
		</form>
	</div>
</div>

<script>
var u_id=<?php echo $uid;?>;
var cate_id=<?php echo $data['cate_id'];?>;


window.onload=function(){
	//页面初始化 拉去下拉目录，显示当前目录
	initCateList($('cateList'),'',cate_id);
	
	//提交按钮
	$('send').onclick=function(){
		//获取dom
		var f=document.forms[0];
		oTitle=f.title;
		oContent=f.content;
		//oCate=f.cate_id;
		//oTags=f.tags;

		//1.检查是否为空
		if(isEmpty(oTitle,'标题')) return;
		if(isEmpty(oContent,'内容')) return;
		
		//2.post方式提交
		var ajax=new Ajax();
		var url='cateAction.php?a=saveItem';
		//拼凑参数
		var para='title='+f.title.value
		 + '&id='+f.a_id.value
		 + '&content='+f.content.value
		 + '&cate_id='+f.cate_id.value
		 + '&tags='+f.tags.value;
		
		n( '&id='+f.a_id.value );
		ajax.post(url,para,function(str){			
			var str=trim(str);
			if(str==false){
				alert('修改失败！请告知管理员。');
			}else{
				alert('修改成功！['+str+']');
				window.location='detail.php?a_id='+str;
			}
		});
		//3.跳转回首页 jump('http://baidu.com',3000);
	}
	
}
</script>

<?php include('footer.php');?>