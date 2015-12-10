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
.category table{ list-style:none; border:1px; text-align:center;}
.category table tr{margin:15px; background:#eee; height: 50px;}
.category table tr.odd{background:#eee;}
.category table tr.even{background:#fff;}
.category table tr td{min-width:250px; overflow:hidden;}
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
<div class='category'>
<a href='index.php'><input type='button' value='&lt;&lt;返回首页' /></a>
<input type='button' id='add' value='添加分类' />

<form method='post' action='doEditCate.php?a=send'>
<table>
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
	
</table>
	
			<input type='button' value="提交" />   
			<a href='index.php'><input type='button' value='&lt;&lt;返回首页(放弃修改)' /></a>


</form>
</div>

<script>
var u_id=<?php echo (new Dawn())->sessionGet('uid');?>;
var cate_id=-1;
function $(s){return document.getElementById(s);}
window.onload=function(){
	$('add').onclick=function(){
		var new_cate=prompt('请输入新分类名字：');
		var ajax=new Ajax();
		ajax.get('doEditCate.php?a=add&name='+new_cate,function(s){
			console.log(s);
			if(s)window.location.reload();
		})
	}

}

</script>

</div>
</body>
<html>