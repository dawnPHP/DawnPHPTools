<?php
include 'header.php';
include 'common/function.php';
?>
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

<?php 

?>

<?php
if(isset($_GET['tag'])){
	echo '<h2>Sort By Tag:</h2>';
	
	$tag=$_GET['tag'];
	//debug($tag);
	$t_id=getIdByTag($tag,$u_id);
	if($t_id!==false){
		showItemsByTag($t_id);
	}else{
		echo '查询失败！<a href="index.php">单击返回</a>';
		die();
	}
}else{
	echo '<h2>Index Mode:</h2>';
	
	//显示标签 by a_id;
	$arr_aid=array(1,2,3,4);
	foreach($arr_aid as $a_id){
		showTags($a_id);
	}
}

?>

</body>
</html>