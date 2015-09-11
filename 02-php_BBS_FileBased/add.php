<style>
table tr td{text-align:right;}
table tr td input[type="text"]{width:100%;}
</style>
<?php
	include("menu.php");
?>

<center>
<h2>发新帖</h2>
<form action="action.php?a=add" method="post" onsubmit="return check(this)" >
<table border="0" width="700">
	<tr>
		<td>姓名</td>
		<td><input type="text" name="name" /></td>
	</tr>
	<tr>
		<td>标题</td>
		<td><input type="text" name="title" /></td>
	</tr>
	<tr>
		<td valign="top">内容</td>
		<td><textarea type="text" rows="4" cols="91" name="text"></textarea></td>
	</tr>
</table>

<input type="submit" name="submit" value="提交" />
<input type="reset" name="reset" value="重置" />

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
</script>