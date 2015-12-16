<?php
session_start();
if(!isset($_SESSION['uid'])){
	die('Invalid visit.');
}
$uid=$_SESSION['uid'];

define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');
?>
<html>
<head>
<link rel="stylesheet" href="public/css/category.css" />
<link rel="stylesheet" href="public/css/edit.css" />
<script src='public/js/ajaxObjPrototype.js'></script>
<script src='public/js/dom.js'></script>
<style>
.main .new{border:1px solid #fefefe; padding:2px;}
.main .new div{border-top:1px solid #fefefe;
	padding:2px;margin:5px;
}
.main .new div input{padding:10px;margin:5px; width:100%;}
.main .new div.content textarea{padding:10px;margin:5px; height:200px;}
.main .new div.cate select{min-width:300px;}
.main .new div.submit input{width:100px;}
.main .new div.submit span{ border:1px solid #aaa; border-radius:10px; padding:2px 10px; opacity:0.5}

.main .new div.tags input{  padding:2px 10px; width:70%;}


</style>
</head>

<body>
<div class='header'>
	<h1>增添&gt;新条目</h1>
		<a href='index.php'><input type='button' class=btn value='&lt;&lt;返回首页' /></a>
<pre>
[1]index.php?cate_id=-1&u_id=2 所有条目
[2]index.php?cate_id=0&u_id=2 默认分类
[3no] index.php?cate_id=-2&u_id=2 回收站
</pre>
</div>

<div class=main>
	
	<div class=new id='new'>
		<form method='post' action='cateAction.php?a=newItem'>
		<div class=title>
			<input type=text name=title placeholder="请输入标题" />
		</div>
		<div class=content>
			<textarea rows="4" name='content' cols="134" placeholder="请在此处介绍自己..."></textarea>
		</div>
		<div class=cate>
			请选择分类：
			<select name='cate_id' id='cateList'>
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


window.onload=function(){
	//页面初始化 拉去下拉目录，当前显示为默认条目
	initCateList($('cateList'));
	
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
		var url='cateAction.php?a=newItem';
		//拼凑参数
		var para='title='+f.title.value
		 + '&content='+f.content.value
		 + '&cate_id='+f.cate_id.value
		 + '&tags='+f.tags.value;
		
		ajax.post(url,para,function(str){
			var str=trim(str);
			if(str==false){
				alert('添加失败！请告知管理员。');
			}else{
				alert('添加成功！['+str+']');
				window.location='detail.php?a_id='+str;
			}
		});
		//3.跳转回首页 jump('http://baidu.com',3000);
	}
	
}
</script>

<?php include('footer.php');?>