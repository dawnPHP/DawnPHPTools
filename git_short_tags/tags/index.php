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
echo '<h2>Index Mode:</h2>';
?>

<?php
//显示标签 by a_id;
$arr_aid=array(1,2,3,4);
foreach($arr_aid as $a_id){
	showTags($a_id);
}


?>

</body>
</html>