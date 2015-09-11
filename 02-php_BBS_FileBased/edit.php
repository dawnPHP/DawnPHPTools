<style>
table tr td{text-align:right;}
table tr td input[type="text"]{width:100%;}
</style>
<?php
	include("menu.php");
	if (!isset($_GET["tid"])){
		die("非法登录.<a href='index.php'>返回首页</a>");
	}
	
	//获得要修改的行
	$tid=$_GET["tid"];
	//使用自定义函数，有tid获得数组：文件前半部分、待修改行、文件后半部分；
	$items=getArrayByTid(DEMOFILE,$tid);
	
	//echo "<pre>";	print_r($items);	echo "</pre>";	die("<hr>console;");
	//获得待修改行
	$item=$items['one'];
	//echo "<pre>"; print_r($item);echo "</pre>";
?>

<center>
<h2>修改帖子</h2>
<form action="action.php?a=update&tid=<?php echo $item[0]?>" method="post" onsubmit="return check(this)" >
<table border="0" width="700">
	<tr>
		<td>姓名</td>
		<td><input type="text" name="name" value="<?php echo $item[1]?>" /></td>
	</tr>
	<tr>
		<td>标题</td>
		<td><input type="text" name="title" value="<?php echo $item[2]?>" /></td>
	</tr>
	<tr>
		<td valign="top">内容</td>
		<td><textarea type="text" rows="4" cols="91" name="text"><?php 
		$item[4]=str_replace("\n","",$item[4]);
		echo $item[4]?></textarea></td>
	</tr>
</table>

<input type="submit" name="submit" value="提交" />
<input type="button" name="cancel" id="cancel" value="取消" />

</form>
</center>

<script>
//除去空格
function trim(str){ //删除左右两端的空格
　　 return str.replace(/(^\s*)|(\s*$)/g, "");
}
function ltrim(str){ //删除左边的空格
	return str.replace(/(^\s*)/g,"");
}
function rtrim(str){ //删除右边的空格
	return str.replace(/(\s*$)/g,"");
}

//检查表单
function check(form){
	var name=form.name.value;
	var title=form.title.value;
	var text=form.text.value;
	if(trim(name).length<1){
		alert("用户名不能为空！");
		return false;
	}
	if(trim(title).length<1){
		alert("帖子标题不能为空！");
		return false;
	}
	
	return true;
}

//取消修改，重定向到首页
function $(s){	return document.getElementById(s);}
window.onload=function(){
	$("cancel").onclick=function(){
		window.location="index.php";
	}
}

</script>