<?php
include 'common/config.php';
include 'common/function.php';
?>
<html>
<head>
<link rel="stylesheet" href="css/category.css" />

</head>

<body>
<div class='header'>
	<h1>(php分类管理系统)php进度跟踪管理系统v1.0</h1>
	<pre>
	<a href='devLog.txt' target='_blank'>开发日志</a>
	分类的增删改查。
	左边分类，右边是条目。默认不分页。
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
			<li class=current><a href='index.php?cate_id=0'>所有分类(100)</a></li>
			<li><a href='index.php?cate_id=1'>分类1(10)</a></li>
			<li><a href='index.php?cate_id=2'>分类2(20)</a></li>
			<li><a href='index.php?cate_id=3'>分类3(80)</a></li>
		</ul>
	</div>

	<!-- 右侧开始 -->
	<div class=right>
		<span class='catalog'>所有类别</span>
		
		<div class='item'>
			<a class='title' href='detail.php?p_id=1' target="_blank">this is the title of item1</a>
			<p>
				2015-11-29 11:08
				<span><a href='action.php?a=del&p_id=1' target="_blank">删除</a></span>
				<span><a href='edit.php?p_id=1' target="_blank">修改</a></span>
			</p>
			<div class='status'>
				<div class='bar c1'></div>
			</div>
		</div>
		
		
		<div class='item'>
			<a class='title' href='detail.php?p_id=1' target="_blank">this is the title of item2</a>
			<p>
				2015-11-29 12:35
				<span><a href='action.php?a=del&p_id=1' target="_blank">删除</a></span>
				<span><a href='edit.php?p_id=1' target="_blank">修改</a></span>
			</p>
			<div class='status'>
				<div class='bar c3'></div>
			</div>
		</div>
		
		
	</div>

</div>


<script>
//


</script>

<div class=footer>
	&copy;2015 All rights reserved;
</div>
</body>
</html>