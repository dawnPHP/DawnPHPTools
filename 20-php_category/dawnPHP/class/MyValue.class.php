<?php
class MyValue{
	//该类操作myvalue表。
	
	//添加value值
	public static function add($cur_uid, $a_id, $key_id, $text){
		$query=sprintf('insert into %smyvalue(a_id,u_id,add_time,key_id,text) values(%s,%s,%d,%s,"%s");',
			DB_TBL_PREFIX,
			mysql_real_escape_string($a_id,$GLOBALS['DB']),
			mysql_real_escape_string($cur_uid,$GLOBALS['DB']),
			time(),
			mysql_real_escape_string($key_id,$GLOBALS['DB']),
			mysql_real_escape_string($text,$GLOBALS['DB'])
		);
		//debug($query);
		$result=mysql_query($query, $GLOBALS['DB']);
		if($result){
			return true;
		}else{
			return mysql_error();
		}
	}



}