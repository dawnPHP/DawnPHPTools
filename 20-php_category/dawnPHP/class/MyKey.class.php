<?php
class MyKey{
	//该类操作mykey表。
	
	//添加key值
	public static function add($cur_uid, $name){
		//先确定不存在，
		$query=sprintf('select * from %smykey where u_id=%d;', 
		DB_TBL_PREFIX,  
		mysql_real_escape_string($cur_uid,$GLOBALS['DB']));

		$rows=mysql_query($query,$GLOBALS['DB']);
		$num=mysql_affected_rows();
		while($row=mysql_fetch_assoc($rows)){
			//如果存在
			if($row['name']==$name){
				return false;
			}
		}

		//然后再添加
		$query2=sprintf('insert into %smykey(name,type,u_id,rank) values("%s",%d, %d, %d);', 
			DB_TBL_PREFIX,  
			mysql_real_escape_string($name,$GLOBALS['DB']),
			mysql_real_escape_string(0,$GLOBALS['DB']),//默认类别是0(txt)
			mysql_real_escape_string($cur_uid,$GLOBALS['DB']), 
			++$num);

		if(mysql_query($query2,$GLOBALS['DB'])){
			return true; 
		}else{
			return false; 
		}
	}
	
	
	//删除key值
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