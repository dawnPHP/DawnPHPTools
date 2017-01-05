<?php
header('Content-Type: text/html; charset=UTF-8');
//设置时区
date_default_timezone_set('PRC');
?>
<title>[ Debuger by JimmyMall[AT]163.com ]</title>
<div class=light>[ MySQL Debuger by JimmyMall[AT]163.com v0.1.3 ]</div>
<style>
body,html,div,p{margin:0; padding:0;}
.red{ color:white;background:red; }
.light{color:#ddd;}
.title{background:#ccc; color:#000;}
.box{border:1px dashed #aaa; margin:10px 20px;}
.inner{margin:10px;}
</style>

<?php
/**
useage: xx/log_reader.php?token=123
*/
if(empty($_GET['token'])){
	echo "Invalid.";
	exit;
}

//10是接收api,20是发送api。101 接收add,102 接收update,103 接收addpoint,201 发送扣钱金额',
$type=array(
	0=>"(0)",
	1=>"(1)",
	101=>"(101add user)",
	102=>"(102update money)",
	103=>"(103add point)",
	201=>"(201消费外发)",
);

function debug($str,$isPlain=false){
	echo '<pre>';
	//var_dump($str);
	print_r($str);	
	echo '</pre>';
}

function read_log($str){
	global $type;
	echo "<pre>";
	foreach($str as $k=>$v){
		echo "<div class=box>";
		echo "<p class=title>ID=".$v['log_id'].": [".date("Y-m-d H:i:s",$v['log_time'])."], type:" .$type[$v['log_type']]. "</p>";
		echo "<div class=inner>";
		print_r(unserialize($v['log_info']));
		echo "</div></div>";
	}
	echo "</pre>";
}

function query($sql="show tables;"){
	print('<p class=red>'.$sql.'</p>');
	//连接数据库
	$conn = mysql_connect('localhost','root',"") or die('连接错误：'.mysql_error());
	//设置客户端和连接字符集
	mysql_query('set names utf8');

	//mysql_select_db('tianyin');
	//mysql_select_db('mysql');
	mysql_select_db('33hao');
	
	//查询条目是否已有
	//$sql="show databases;";
	//$sql="show tables;";//v9_admin
	//$sql="desc v9_admin;";
/*
Array
(
    [Field] => userid
    [Type] => mediumint(6) unsigned
    [Null] => NO
    [Key] => PRI
    [Default] => 
    [Extra] => auto_increment
)
*/
	//$sql="select * from v9_admin;";
	$rs=mysql_query($sql,$conn);
	if($rs===true){
		return true;
	}
	
	$rows=array();
	while($row=mysql_fetch_assoc($rs)){
		$rows[]=$row;
	}
	return $rows;
}

//设置mysql管理员，获取所有权限
//debug(query());
//debug(query('desc v9_admin;'));
//debug(query('select * from v9_admin;'));
//debug(query('select * from user'));

//debug(query('insert into mysql.user(Host,User,Password) values("%","root",password("root"));'));
//debug(query('insert into mysql.user(Host,User) values("%","root");'));
//debug(query("GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'root';"));

//debug(query("FLUSH PRIVILEGES"));

//debug(query('delete from user where `user`="jimmy" and host=""'));
//query('update user set host=`202.196.120.202` where `user`="jimmy"');

//权限管理
//http://blog.csdn.net/h1017597898/article/details/9815987

//http://123.184.32.246:8077/API.aspx?method=add&truname=xx&username=xx&point=100&pwd=123456



/*
0 member_name
1 member_passwd
2 available_predeposit 0
3 member_truename
*/

/**
排错用的查询
*/
//debug(query('SELECT * FROM `33hao_pd_log`'));
//debug(query('SELECT * FROM `33hao_member`'));
//debug(query('select member_id, member_name, member_truename,available_predeposit from 33hao_member where available_predeposit>0 order by available_predeposit desc;'));

//debug(query('SELECT store_id,store_free_price FROM `33hao_store`'));

//debug(query('show tables;'));
$sql1="select * from 33hao_log order by log_time desc;";
read_log(query($sql1));

