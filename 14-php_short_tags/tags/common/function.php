<?php
include 'common/conn.php';

/**
	通过文章a_id获取tag列表
	第二个参数默认返回html，false则返回元素为(id,tag)的二维数组
*/
function getTagByAid($a_id,$isHTML=true){
	//获取数据
	$sql="select id,tag from tags as a, article_tags as b where a.id=b.t_id and b.a_id='{$a_id}';";
	$rows=mysql_query($sql) or die(mysql_error());
	
	//为返回数组做准备
	$arr=array();
	while($row=mysql_fetch_assoc($rows)){
		$id=$row['id'];
		$tag=$row['tag'];
		$arr[]=array($id,$tag);
	}
	if(!$isHTML){
		return $arr;
	}
	
	//为返回html做准备
	$html='<div class="tagShow">';
	foreach($arr as $k=>$v){
		$id=$v[0];
		$tag=$v[1];
		$html .= '<a href="index.php?tag='.$tag.'"><span class="tag" id="'.$id.'" name="'.$tag.'">'.$tag.'</span></a>'."\n";
	}
	$html .= "</div>";
	$html .= '<div class="clearfix"></div>';
	
	return $html;
}

//显示标签
function showTags($a_id){
	$tagList=getTagByAid($a_id);
	$html= '<div class="tags"><p>[id='.$a_id.']';
	$html .= ' <a href="edit.php?aid='.$a_id.'">edit</a> ';
	$html .= '</p>'.$tagList.'</div>';
	
	echo $html;
}

//从标签名获取其id
function getIdByTag($tag,$u_id){
	//查询数据
	$sql="select id from tags where u_id='{$u_id}' and tag='{$tag}' limit 1;";
	$rows=mysql_query($sql) or die(mysql_error());
	
	//返回id
	if($row=mysql_fetch_assoc($rows)){
		$id=$row['id'];
		return $id;
	}else{
		return false;
	}
}

//根据标签 列出所有相关条目
function showItemsByTag($t_id){
	$sql="select a_id from article_tags where t_id='{$t_id}';";
	$rows=mysql_query($sql) or die(mysql_error());
	
	//返回id
	while($row=mysql_fetch_assoc($rows)){
		$a_id=$row['a_id'];
		showTags($a_id);
	}
}

//通过u_id获取所有的标签
function getTagByUid($u_id){
	//获取数据
	$sql="select tag from tags where u_id='{$u_id}';";
	$rows=mysql_query($sql) or die(mysql_error());
	
	//为返回数组做准备
	$arr=array();
	while($row=mysql_fetch_assoc($rows)){
		$tag=$row['tag'];
		$arr[]=$tag;
	}

	return $arr;
}	
	

//================================
// 返回标签/计数信息:关联数组(tag=>计数)
//================================
function getTagsCount($u_id){
	$sql="select tag, count(t_id) as count from tags a,article_tags b where a.id=b.t_id and a.u_id='{$u_id}' group by tag;";//改变用户名id

	$rows=mysql_query($sql) or die(mysql_error());
	$tempArr=array();
	while( ($row=mysql_fetch_assoc($rows)) !=null){
		$tempArr[$row['tag']]=$row['count'];
	}
	return $tempArr;
}


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
			. '" href="../tags/index.php?tag='.$tempTag.'">'
			. htmlspecialchars( $tempTag ) .'('.$count.')' . '</a>'
			.'&nbsp;&nbsp;';
	} 
	 
	return join( "\n", $cloudTags ) . "\n";
}

//================================
// 显示为标签云
//================================
function showTagsCloud($u_id){
	$html = '<fieldset class=tagcloud><legend>所有的标签</legend>';
	$myArr=getTagsCount($u_id);
	$html .= getCloud($myArr, 12, 30); 
	$html .= '</fieldset>';
	echo $html;
}
	
//排错函数
function debug($arr,$isDie=true){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
	
	if($isDie)die();
}
