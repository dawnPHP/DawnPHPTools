<?php
include 'conn.php';
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
		$uid=1;//从session中读取用户id
		$aTag=explode(',',$tags);
		print_r($aTag);
		addTagsToDb($aTag,$uid,$a_id);
}

/**
	把提交的标签插入到新的mysql中
*/
function addTagsToDb($aTag,$uid,$a_id){
	//从tag表获取该用户的所有标签
	$allTags=getTagsBy('uid',$uid);

	for($i=0;$i<count($aTag);$i++){
		$tag=$aTag[$i];
		//1.是否重复
		if( in_array($tag,$allTags) ){ 
			continue;//重复的不再处理
		}else{
			//否则添加到数据库中
			$sql="insert into tags(u_id,tag) values('{$uid}','{$tag}')";
		}
		//2.是否合适
		
	}
	

}

/**
	从tag表获取该用户的所有标签
*/
function getTagsBy($key,$value){
	$sql="select * from tags where $key=$value";
	$rows=mysql_query($sql);
	$arr=array();
	while( $row=mysql_fetch_assoc($rows) ){
		$arr[]=$row['tag'];
	}
	return $arr;
}

/*
伪代码

删除关联表中aid对应的条目；

对标签遍历{
	if(tag not in tableTags){
		添加到tags表；
		获取tag的id；
		插入到tags表中；
		
	}else{
		获取tag的id；
		插入到tags表中；
	}
}

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