<?php
session_start();
if(!isset($_SESSION['uid'])){
	die('Invalid visit.');
}
$uid=$_SESSION['uid'];

define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/php_category/dawnPHP/");
include('dawnPHP/mylib.php');

//获取数据
$sql='select id,name,u_rank from category where u_id='.$uid;
$rows=mysql_query($sql,$GLOBALS['DB']);
?>

<html>
<head>
<title>修改分类</title>
<link rel="stylesheet" href="public/css/category.css" />
<script src='public/js/ajaxObjPrototype.js'></script>
<script src='public/js/dom.js'></script>
<style>
.category{ list-style:none; border:1px; text-align:center;}
.category tr{margin:15px; background:#eee; height: 50px;}
.category tr.odd{background:#eee;}
.category tr.even{background:#fff;}
.category tr td{min-width:250px; overflow:hidden;}
.category input{padding:10px;margin:10px; border:0px; 
	border-bottom:1px #000 solid;border-right:1px #000 solid;}
.category input[type='text']{width:90%;height:100%;}
</style>
</head>
<body>

<div class=header>
<h1>修改目录</h1>
<pre>
	可以增添、删除、修改目录名称。
	可以修改目录的显示顺序。	
</pre>
<a href='index.php'>返回首页</a> | 
<a href='index.php'><input type='button' value='添加' /></a>
<form method='post' action='doEditCate.php?a=send'>
<table class='category'>
	<tr>
		<th>目录名称</th>
		<th>显示顺序</th>
		<th>操作</th>
	</tr>
<?php 
	$i=1;
	while($row=mysql_fetch_assoc($rows)){
		$i++;
?>
	<tr class=<?php echo ($i%2==0)?'even':'odd'; ?>>
		<input type='hidden' name='id[]' value="<?php echo $row['id']?>" />
		<td><input type='text' name='name[]' value="<?php echo $row['name']?>" /></td>	
		<td><input type='text' name='u_rank[]' value="<?php echo $row['u_rank']?>" /> </td>
		<td><a href='doEditCate.php?a=del<?php echo "&cate_id={$row['id']}";?>'>删除</a></td>
	</tr>
<?php }?>
	
	<tr>
		<td colspan=3><input type='submit' value="提交" />   
		<input type='button' name='send' value="取消" /></td>
	</tr>
</table>

</form>

<script>
var u_id=<?php echo (new Dawn())->sessionGet('uid');?>;
var cate_id=-1;
window.onload=function(){


}

</script>

</div>
</body>
<html>