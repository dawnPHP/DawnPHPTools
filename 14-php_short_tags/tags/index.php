<?php
include 'header.php';
include 'common/function.php';
?>


<?php
//显示标签云
showTagsCloud($u_id);

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
	$arr_aid=array(1,2,3,4,5,6);
	foreach($arr_aid as $a_id){
		showTags($a_id);
	}
}

?>

</body>
</html>