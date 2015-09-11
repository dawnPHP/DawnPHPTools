<center>
<?php
include("menu.php");

//打开文件
$fh=fopen(DEMOFILE,"r");

//读取get方式传递的tid值
if(isset($_GET['tid'])){
	$tid=$_GET['tid'];
	echo "<p>帖子编号：{$tid}</p>";

	//找到文件位置
	$isFind=false;//
	echo "<ul class=box>";
	while($item=fgetcsv($fh)){
		if ($item[0]==$tid){
			echo "<li>帖子ID：{$item[0]}</li>";
			echo "<li>发帖人：{$item[1]}</li>";
			echo "<li>标题：{$item[2]}</li>";
			echo "<li>发布时间：".date("Y-m-d H:i:s", $item[3])."</li>";
			echo "<li>内容：{$item[4]}</li>";
			$isFind=true;
			break;
		}
	}
	echo "</ul>";
	if(!$isFind) echo "<span class=red>没有该帖子！</span>";
}else{
	//打印所有文件
	echo "<ul class=box id=box>";
	while($item=fgetcsv($fh)){
		if(!isset($item[0])) continue;
		echo "<li><span class=light>[{$item[0]}] ".
			date("Y-m-d H:i:s", $item[3]).
			" | {$item[1]} | <a target='_blank' href='index.php?tid=".$item[0]."'>{$item[2]}</a>".
			"</span> | <a class=btn id=del{$item[0]} target='_blank' title='".$item[0]."'>删除</a>".
			" | <a class=btn target='_blank' href='edit.php?tid=".$item[0]."'>修改</a>".
			"</li>";
	}
	echo "</ul><hr>";
}


//关闭文件
fclose($fh);
?>

</center>

<script>
function $(s){return document.getElementById(s);};
window.onload=function(){
	var aATags=$("box").getElementsByTagName("a");
	
	for(var i=0; i<aATags.length; i++){
		var _this=aATags[i];
		if(_this.title != ""){
			_this.onclick=deleteItem;
		}
	}
	
	//href="action.php?a=del&tid="+$item[0];
	function deleteItem(){
		if(confirm('确定删除tid=' + this.title +"的记录吗？")){
			this.href="action.php?a=del&tid="+this.title;
		}
	};
}

</script>