<html>
<head>
<link rel="stylesheet" href="tags.css" />
<title>仿163博客添加文章标签功能</title>
</head>
<body>
<h1>仿163博客添加文章标签功能</h1>
<pre>
1.前台基于js，后台基于php。
2.完稿后第一行隐藏，用于提交表单：用户添加的标签。
3.相关博客：http://tieba.baidu.com/p/4174331708
</pre>
<style>
.tags {border:1px dashed #ddd; padding:10px;}
.tags .clearfix{	clear:both;}
.tags .tagShow{float:left; }
.tags .tagShow span{
	cursor: pointer;
}
.tags .tagShow .tag{
	background:lightblue;
	color: #fff;
	padding: 2px 5px;
	display: block;
	float: left;
	margin:5px 5px 5px 0;
}
</style>
<hr><br>
<a href='new.php' target="_blank">新建</a>
<?php
include 'conn.php';

/**
	通过文章a_id获取tag列表
*/
function getTagBy($a_id){
	//获取数据
	$sql="select id,tag from tags as a, article_tags as b where a.id=b.t_id and b.a_id='{$a_id}';";
	$rows=mysql_query($sql) or die(mysql_error());
	$html='<div class="tagShow">';
	while($row=mysql_fetch_assoc($rows)){
		$id=$row['id'];
		$tag=$row['tag'];
		//$html .= '<span class="tag" id="'.$id.'" name="'.$tag.'">'.$tag.'</span>'."\n";
		$html .= '<a href="index.php?tag='.$tag.'"><span class="tag" id="'.$id.'" name="'.$tag.'">'.$tag.'</span></a>'."\n";
		//print_r($html);die();
	}
	$html .= "</div>";
	$html .= '<div class="clearfix"></div>';
	
	return $html;
}

//显示标签
function showTags($a_id){
	$tagList=getTagBy($a_id);
	$html= '<div class="tags"><p>[id='.$a_id.']';
	$html .= ' <a href="edit.php?aid='.$a_id.'">edit</a> ';
	$html .= '</p>'.$tagList.'</div>';
	
	echo $html;
}

//显示标签 by a_id;
$arr_aid=array(1,2,3,4);
foreach($arr_aid as $a_id){
	showTags($a_id);
}

?>

</body>
</html>