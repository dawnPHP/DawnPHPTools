<style>
.red{ color:white;background:red; }
</style>
<?php
/**
	修改MySQL数据库名字，然后一条一条执行并输出sql结果。




*/

function debug($str){
	echo '<pre>';
	//var_dump($str);
	print_r($str);
	echo '</pre>';
}


function query($sql="show tables;"){
	print('<p class=red>'.$sql.'</p>');
	//连接数据库
	$conn = mysql_connect('localhost','root','root') or die('连接错误：'.mysql_error());
	//mysql_select_db('tianyin');
	mysql_select_db('mysql');
	
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
	$rows=array();
	while($row=mysql_fetch_assoc($rs)){
		$rows[]=$row;
	}
	return $rows;
}


//debug(query());
//debug(query('desc v9_admin;'));
//debug(query('select * from v9_admin;'));
debug(query('select * from user'));
//debug(query('insert into mysql.user(Host,User,Password) values("","jimmy",password("1qazxsw2"));'));
//debug(query("GRANT ALL PRIVILEGES ON *.* TO 'jimmy'@'%' IDENTIFIED BY '1qazxsw2';"));

//debug(query('delete from user where `user`="jimmy"'));
//query('update user set host=`202.196.120.202` where `user`="jimmy"');

//权限管理
//http://blog.csdn.net/h1017597898/article/details/9815987