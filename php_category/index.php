<?php
define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');

/*
1.从session中获取一个u_id，否则提示登陆。
2.如果该u_id是管理员或本文作者，则显示，否则不显示。
3.

*/
?>
<html>
<head>
<link rel="stylesheet" href="public/css/category.css" />
<script src='public/js/ajaxObjPrototype.js'></script>
<script src='public/js/dom.js'></script>
</head>

<body>
<div class='header'>
	<h1>(php分类管理系统)php进度跟踪管理系统v1.0</h1>
	<pre>
	<a href='devLog.txt' target='_blank'>开发日志</a> | <a href='http://tieba.baidu.com/f?kw=php&fr=wwwt' target='_blank'>php吧</a> | index.php?cate_id=4&u_id=2
	分类的增删改查。 | 	左边分类，右边是条目。默认不分页。
	
	[1]index.php?cate_id=-1&u_id=2 所有条目
	[2]index.php?cate_id=0&u_id=2 默认分类
	[3no] index.php?cate_id=-2&u_id=2 回收站
	</pre>
</div>

<div class=main>
	<!-- 左侧开始 -->
	<div class=left>
		<div class=btn>
			<input type='button' value='新建条目'>
			<p><a href='javascript:void(0);'>管理分类</a> | 
			<a href='javascript:void(0);'>管理条目</a></p>
		</div>
		<span>分类</span>
		<ul>
			<!--li class=current><a href='index.php?cate_id=0'>所有分类(100)</a></li>
			<li><a href='index.php?cate_id=1'>分类1(10)</a></li-->
		</ul>
	</div>

	<!-- 右侧开始 -->
	<div class=right>
		<span class='catalog'> 条目列表:</span>
		
		<!--div class='item'>
			<a class='title' href='detail.php?p_id=1' target="_blank">this is the title of item1</a>
			<p>
				2015-11-29 11:08
				<span><a href='action.php?a=del&p_id=1' target="_blank">删除</a></span>
				<span><a href='edit.php?p_id=1' target="_blank">修改</a></span>
			</p>
			<div class='status'>
				<div class='bar c1'></div>
			</div>
		</div-->
	</div>
</div>



<script>
var cate_id=<?php echo Dawn::get('cate_id','-1'); ?>;
var u_id=<?php echo (new Dawn())->get('u_id',-1);?>;
window.onload=function(){
	//绑定事件
	var oBtns=document.getElementsByClassName('left')[0].getElementsByClassName('btn')[0];
	var oBtn_new=oBtns.getElementsByTagName('input')[0];//新建按钮
	var oBtn_manage=oBtns.getElementsByTagName('p')[0].getElementsByTagName('a');
	var oBtn_cate=oBtn_manage[0];//管理分类
	var oBtn_item=oBtn_manage[1];//管理条目
	
	oBtn_new.onclick=function(){
		alert(this.value);
	}
	oBtn_cate.onclick=function(){
		window.location='editCate.php';
	}
	oBtn_item.onclick=function(){
		window.location='changeCate.php';
	}	
	
	//请求目录
	var url='cateAction.php?a=category&u_id='+u_id;
	var ajax=new Ajax();
	ajax.get(url,function(s){
		var objs=eval("("+s+")");
		if(objs.length==0){return;}
		showCate(objs);
	});
	
	//请求文章
	var url2='cateAction.php?a=artilist&u_id='+u_id+'&cate_id='+cate_id;
	var ajax2=new Ajax();
	ajax2.get(url2,function(s){
		var objs=eval("("+s+")");
		showArticle(objs);
	});
	
}
</script>

<div class=footer>
	&copy;2015 All rights reserved;
</div>
</body>
</html>