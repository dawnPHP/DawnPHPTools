<?php
class MyKey{
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
	public static function del($cur_uid, $key_id, $type){
		//获取myvalue表记录，
		$rows=MyValue::getValuesBy($cur_uid, $key_id);
		//删除文件。记录将要删除的myvalue行号
		$id_str='(';
		while($row=mysql_fetch_assoc($rows)){
			/* Array( [id] => 1, [text] => upload/usr_1/001.jpg )  [id]=>29*/
			$id_str .= $row['id'].',';
			//删除文件
			if($type>0){
				//获取文件地址，删除文件
				@unlink($row['text']);
			}
		}
		//删除myvalue表记录
		$id_str=substr($id_str,0, strlen($id_str)-1) . ')';
		$sql='delete from myvalue where id in ' . $id_str;
		mysql_query($sql, $GLOBALS['DB']);
		
		
		//删除mykey数据库记录
		$query=sprintf('delete from %smykey where u_id=%d and id=%d;',
			DB_TBL_PREFIX,
			mysql_real_escape_string($cur_uid,$GLOBALS['DB']),
			mysql_real_escape_string($key_id,$GLOBALS['DB'])
		);
		$result=mysql_query($query, $GLOBALS['DB']);
		if(mysql_affected_rows()>0){
			return array(1, 'delete success!');
		}else{
			return array(0, mysql_error() );
		}
	}
	
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



}