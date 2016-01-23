<?php
class Property{
	//该类操作mykey和myvalue两个表。
	//select k.name,k.type,v.text, v.id from mykey k left join myvalue v on k.id=v.key_id where k.u_id=v.u_id and v.a_id=42 order by k.rank;

	
	//获取条目详细信息
	public static function detail($uid,$a_id){
		$arr=array();
		//1.执行查询mykey表的条目
		$query=sprintf('select * from %smykey where u_id=%d order by rank;',
			DB_TBL_PREFIX,
			mysql_real_escape_string($uid,$GLOBALS['DB'])
		);
		$result=mysql_query($query, $GLOBALS['DB']);
		$arr['key']=array();
		while($row=mysql_fetch_assoc($result)){
			$arr['key'][]=$row;
		}
		
		//2.执行查询myvalue表的条目
		$query=sprintf('select * from %smyvalue where a_id=%d and u_id=%d;',
			DB_TBL_PREFIX,
			mysql_real_escape_string($a_id,$GLOBALS['DB']),
			mysql_real_escape_string($uid,$GLOBALS['DB'])
		);
		$result=mysql_query($query, $GLOBALS['DB']);
		$arr['value']=array();
		while($row=mysql_fetch_assoc($result)){
			$arr['value'][]=$row;
		}

		//3.释放内存
		mysql_free_result($result);
		//4.返回数组
		return $arr;
	}
}