<?php
include 'common/function.php';
echo '<pre>';
/*
print_r($_SESSION);
print_r($_GET);
print_r($_POST);
*/
if(!isset($_POST['send'])){
	die('invalid url;');
}

switch($_GET['a']){
	case 'tag':
		$tags=$_POST['tags'];
		$a_id=$_POST['a_id'];//文章id
		$u_id=$_POST['u_id'];//从session中读取用户id
		$aTag=explode(',',$tags);
		print_r($aTag);
		addTagsToDb($aTag,$u_id,$a_id);
		break;
	default:
		break;
}


//跳转
header("Location: index.php");
exit();



//=================================

/**
	把提交的标签插入到新的mysql中
*/
function addTagsToDb($aTag,$u_id,$a_id){
	//从tag表获取该用户的所有标签
	$allTags=getTagsBy($u_id);
	//在关联表中 删除aid的标签
	$sql="delete from article_tags where a_id='{$a_id}'";
	mysql_query($sql) or die('Delete Err:'.mysql_error());
	
	//添加标签的逻辑
	for($i=0;$i<count($aTag);$i++){
		$tag=$aTag[$i];
		//1.是否重复
		$result=in_array2($tag,$allTags);
		if( false==$result ){
			//否则添加到tags表中
			$sql="insert into tags(u_id,tag) values('{$u_id}','{$tag}')";
			mysql_query($sql) or die(mysql_error());
			$t_id=mysql_insert_id();
			//echo 'no';print_r($t_id);die();//no2
			//向关联表添加数据
			addTo_tb_Assoc($a_id,$t_id);
			
		}else{
			//重复的不再添加到tags表中  //print_r($arr);die();//todo
			$t_id=$result[0];
			//echo '~~old~~'.$t_id; print_r($tag);die();
			//向关联表添加数据
			addTo_tb_Assoc($a_id,$t_id);
		}
	}
}

/**
	向article_tags表中添加数据
*/
function addTo_tb_Assoc($a_id,$t_id){
	$sql="insert into article_tags(a_id, t_id) values('{$a_id}','{$t_id}')";
	mysql_query($sql) or die(mysql_error());
}


/**
	检测$tag是否在$allTags[1]中
*/
function in_array2($tag,$allTags){
	for($i=0;$i<count($allTags);$i++){
		if($allTags[$i][1]==$tag){
			return array( $allTags[$i][0] );
		}
	}
	return false;
}



/**
	从tag表获取该用户的所有标签
*/
function getTagsBy($u_id){
	$sql="select id,tag from tags where u_id='{$u_id}'";
	$rows=mysql_query($sql);

	$arr=array();
	while( $row=mysql_fetch_assoc($rows) ){
		$arr[]=array($row['id'],$row['tag']);
	}
	//print_r($arr);die();
	return $arr;
}

/*
伪代码

删除关联表中aid对应的条目；

对标签遍历{
	if(tag not in tableTags){
		添加到tags表；
		获取tag的id；
		插入到关联表中；
		
	}else{
		获取tag的id；
		插入到关联表中；
	}
}


truncate table table_name;
*/

/*
--建立tags表
create table tags(
	id int(10) not null auto_increment primary key,
	u_id int(10),
	tag varchar(20)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--建立关联表article_tags表
create table article_tags(
	a_id int(10) not null,
	t_id int(10) not null,
	primary key(a_id,t_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

*/