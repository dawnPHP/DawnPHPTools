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
<a href='index.php'><input type='button' class=btn value='&lt;&lt;返回首页' /></a>

<span class='spanceWidth'></span>

选择分类：
<select id='cateList'>
	<option value='0'>所有分类</option>
	<option value='1'>xxx1</option>
	<option value='3'>xxx3</option>
</select>

<span class='spanceWidth'></span>

选择新分类：
<select id='newCateList'>
	<option value='0'>所有分类</option>
	<option value='1'>xxx1</option>
	<option value='3'>xxx3</option>
</select>
<span class='spanceWidth'></span>

<input type='button' id='change' class='btn blue' value='确认修改' />

<form method='post' action='doEditCate.php?a=send'>
<table>
	<tr>
		<th>选择</th>
		<th>条目标题</th>
		<th>添加日期</th>
	</tr>
	<div id='item'>
	
	<tr>
		<td><input type='checkbox' name='isSelect'></td>
		<td>条目标题1条目标题1条目标题1条目标题1条目标题1条目标题1</td>
		<td>2015-12-11</td>
	</tr>
	
	</div>
</table>
</form>

</div>

</body>
</html>
<script>
window.onload=function(){
	var ajax=new Ajax();
	//var url='doChangeCate.php?a=catelist';
	var url='cateAction.php?a=category';
	ajax.get(url,function(s){
		var selection=$('cateList');
		var newSelection=$('newCateList');
		selection.innerHTML='';
		newSelection.innerHTML='';
		
		var objs=eval("("+s+")");
		if(objs==[]){return;}
		for(var i=0;i<objs.length;i++){
			refreshCateSelection(objs[i],selection);
			newSelection.innerHTML=selection.innerHTML;
		}
	});
	
	//在管理条目页面中，修改条目分类：显示所有分类
	function refreshCateSelection(obj,selection){
		//1.造dom
		//Object {id: "22", name: "html", u_id: "2", u_rank: "1", count: 0}
		var oOption=document.createElement('option');
		oOption.setAttribute('value',obj['id']);
		oOption.innerHTML=obj['name'];
		if(obj['u_rank']==-1){
			oOption.setAttribute('selected','selected');
		}
		//2.插入selection
		selection.appendChild(oOption);
	}
	
	//如果改变条目，则显示
	$('cateList').onchange=function(){
		var cate_id=this.value;
		showArticleListByCate(cate_id);
	}
	
	//显示该目录下的条目
	function showArticleListByCate(cate_id){
		//1.请求json
		
		//2.循环
		
		//3.组装dom
		
		//4.插入dom树
	}

}

</script>



