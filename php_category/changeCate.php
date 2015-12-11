<?php
session_start();
if(!isset($_SESSION['uid'])){
	die('Invalid visit.');
}
$uid=$_SESSION['uid'];

define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');

//获取数据
$sql='select id,name,u_rank from category where u_id='.$uid . ' order by u_rank';
$rows=mysql_query($sql,$GLOBALS['DB']);
?>

<html>
<head>
<title>更新条目分类</title>
<link rel="stylesheet" href="public/css/category.css" />
<link rel="stylesheet" href="public/css/edit.css" />
<script src='public/js/ajaxObjPrototype.js'></script>
<script src='public/js/dom.js'></script>
</head>
<body>

<div class=header>
<h1>管理&gt;更新条目分类</h1>
<pre>
	可以更新条目的分类。	
</pre>
<div class='category'>
<a href='index.php'><input type='button' value='&lt;&lt;返回首页' /></a>
<input type='button' id='add' class='btnblue' value='添加分类' />

选择分类：

<form method='post' action='doEditCate.php?a=send'>
<table>
	<tr>
		<th>目录名称</th>
		<th>显示顺序</th>
		<th>操作</th>
	</tr>
</table>
</form>

</div>




