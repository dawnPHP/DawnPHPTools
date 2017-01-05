<?php 
//输出函数
function debug($str){
	echo '<pre>';
	//var_dump($str);
	print_r($str);
	echo '</pre>';
}


//测试MysqlHelper类
include "utils\db\MysqlHelper.class.php";
use utils\db\MysqlHelper;//带有namespace的类
$mysql=new MysqlHelper("localhost",'root','');

$mysql->select_db('think');

$rs=$mysql->query("select * from think_user"); //查询返回二维数组
//$rs=$mysql->execute("update think_user set modi_time='1451294959' where id in (5,6,7)");//修改返回受影响条目
debug($rs);

