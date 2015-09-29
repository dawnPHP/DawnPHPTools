<?php
/**
name:counter
version:1.0.1
*/

$aid  = isset( $_GET['aid'] )?$_GET['aid']:'';
$class = isset( $_GET['c'] )?$_GET['c']:'';
	
if($aid!=''){	
	$num=counter($aid);
	//print_r();//使用函数计数
	echo "document.write('".$num."');";
}
	
/**
name:单页计数器
aim:根据传入的aid，确定aid一共出现的次数。
aid是字符串。记录博客时，可以用字母a+文章编号。
*/	
function counter($aid){	
	//连接数据库
	if(!isset($conn)){
		$conn = mysql_connect('192.168.1.100','root','');
		mysql_select_db('myBlog');
	}
	
	//查询条目是否已有
	$sql="select click_num from counter where aid ='{$aid}'";
	$rows=mysql_query($sql,$conn);
	
	//如果不存在则创建，存在则自增
	if(mysql_affected_rows()<=0){
		//创建条目
		$sql="insert into counter(aid,click_num) values('{$aid}',1);";
		mysql_query($sql,$conn) or die('insert Err: ' . mysql_error());
		$num=0;
	}else{
		//增加浏览次数
		$row=mysql_fetch_assoc($rows);
		$num=$row['click_num'];
		//echo "document.write('这里是显示浏览次数,可以从数据库读出来');";
		$sql = "Update counter set click_num = click_num+1 where aid ='$aid'";
		mysql_query($sql,$conn) or die('update Err: ' . mysql_error());
	}
	//返回条目浏览次数
	//使用时 echo "document.write('".$num."');";
	return $num+1;
}


/*
--
-- 表的结构 `counter`
--
CREATE TABLE IF NOT EXISTS `counter` (
  `id` int(20) NOT NULL auto_increment PRIMARY KEY ,
  `aid` varchar(20) default NULL UNIQUE KEY,
  `click_num` int(20) default NULL,
  `class` varchar(20) default 'blog'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
+-----------+---------+------+-----+---------+----------------+
| Field     | Type    | Null | Key | Default | Extra          |
+-----------+---------+------+-----+---------+----------------+
| id        | int(11) | NO   | PRI | NULL    | auto_increment |
| aid       | int(11) | YES  | UNI | NULL    |                |
| click_num | int(11) | YES  |     | NULL    |                |
+-----------+---------+------+-----+---------+----------------+
unique ky 与primary key的区别：
http://zccst.iteye.com/blog/1697043
*/


?>

