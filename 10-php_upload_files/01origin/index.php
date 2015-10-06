<style>
.wrap{width:1000px; border:#000 1px solid; margin:0 auto;
	box-shadow:15px 15px #eee;
	padding:10px;
}
.pics{width:200px; margin:5px; border:#eee 10px solid; }

</style>
<div class=wrap>
<h1>图片预览</h1>
<a href="upload.html">上传图片</a>
<hr>
<?php
$rs=glob("upload/"."*.*");
$i=0;
foreach($rs as $picName){
	if(($i++)%4==0) echo "<br>";
	$picName=iconv("GBK","UTF-8",  $picName);//从gbk到utf-8
	$title=substr($picName,7,-4); //截取字符串
	echo "<img class=pics title='{$title}' src='{$picName}'>\n";
}
?>

</div>