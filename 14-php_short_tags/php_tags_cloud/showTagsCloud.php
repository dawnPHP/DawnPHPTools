<?php

//================================
// 返回标签云
//================================
function getCloud( $data = array(), $minFontSize = 12, $maxFontSize = 50 ){
	$minimumCount = min( array_values( $data ) );
	$maximumCount = max( array_values( $data ) );
	$spread = $maximumCount - $minimumCount;
	$cloudHTML = '';
	$cloudTags = array(); 
	 
	$spread == 0 && $spread = 1; 
	 
	foreach( $data as $tag => $count )
	{
		$tempTag=stripslashes( $tag );
		$size = $minFontSize + ( $count - $minimumCount )
				* ( $maxFontSize - $minFontSize ) / $spread;
		$cloudTags[] = '<a style="font-size: ' . floor( $size ) . 'px'
					. '" href="../tags/index.php?tag='.$tempTag.'" title="\'' . $tag .
					'\' returned a count of ' . $count . '">'
					. htmlspecialchars( $tempTag ) .'('.$count.')' . '</a>'.'&nbsp;&nbsp;';
	} 
	 
	return join( "\n", $cloudTags ) . "\n";
}
/**************************
* 标签名 使用次数
**** Sample usage *** /
$arr = Array('Actionscript' => 35, 'Adobe' => 22, 'Array' => 44, 'Background' => 43,
'Blur' => 18, 'Canvas' => 33, 'Class' => 15, 'Color Palette' => 11, 'Crop' => 42,
'Delimiter' => 13, 'Depth' => 34, 'Design' => 8, 'Encode' => 12, 'Encryption' => 30,
'Extract' => 28, 'Filters' => 12);
echo getCloud($arr, 12, 36); 
*/

//排除函数
function debug($a){
	echo '<pre>';
	print_r($a);
	echo '</pre>';
	die();
}


//获取标签/计数信息:关联数组(tag=>计数)
function getTagsCount($u_id){
	$sql="select tag, count(t_id) as count from tags a,article_tags b where a.id=b.t_id and a.u_id='{$u_id}' group by tag;";//改变用户名id

	$rows=mysql_query($sql) or die(mysql_error());
	$tempArr=array();
	while( ($row=mysql_fetch_assoc($rows)) !=null){
		$tempArr[$row['tag']]=$row['count'];
	}
	return $tempArr;
}

//
include '../tags/common/conn.php';
$myArr=getTagsCount(1);
echo getCloud($myArr, 12, 30); 