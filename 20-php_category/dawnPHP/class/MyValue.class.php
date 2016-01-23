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
	
	
	//删除value值
	public static function del($cur_uid, $id, $type){
		//删除文件
		if($type>0){
			//获取文件地址
			$filepath=self::getFilePath($cur_uid, $id);
			//删除文件
			@unlink($filepath);
		}
		
		//删除数据库记录
		$query=sprintf('delete from %smyvalue where u_id=%d and id=%d;',
			DB_TBL_PREFIX,
			mysql_real_escape_string($cur_uid,$GLOBALS['DB']),
			mysql_real_escape_string($id,$GLOBALS['DB'])
		);
		$result=mysql_query($query, $GLOBALS['DB']);
		if(mysql_affected_rows()>0){
			return array(1, 'delete success!');
		}else{
			return array(0, mysql_error() );
		}
	}
	
	
	//获取文件路径
	public static function getFilePath($cur_uid, $id){
		//查询数据库记录
		$query=sprintf('select * from %smyvalue where u_id=%d and id=%d;',
			DB_TBL_PREFIX,
			mysql_real_escape_string($cur_uid,$GLOBALS['DB']),
			mysql_real_escape_string($id,$GLOBALS['DB'])
		);

		//查询
		$result=mysql_query($query, $GLOBALS['DB']);
		$row=mysql_fetch_assoc($result);
		
		//返回
		return $row['text'];		
	}
	
	//获取某个属性的所有值:value_id, path
	public static function getValuesBy($cur_uid, $key_id){
		//查询数据库记录
		$query=sprintf('select id, text from %smyvalue where u_id=%d and key_id=%d;',
			DB_TBL_PREFIX,
			mysql_real_escape_string($cur_uid, $GLOBALS['DB']),
			mysql_real_escape_string($key_id, $GLOBALS['DB'])
		);

		//查询
		return mysql_query($query, $GLOBALS['DB']);
	}



}