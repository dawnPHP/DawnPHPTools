<?php
class Category{
	private $id;
	private $fields;
	
	public function __construct(){
		$this->id=null; 
		$this->fields=array('name'=>'','u_id'=>'','u_rank'=>''); 
	}
	
	public function __get($field){
		if($field=='cate_id'){
			return $this->id; 
		}else{
			return $this->fields[$field]; 
		}
	}
	
	public function __set($field,$value){
		if(array_key_exists($field,$this->fields)){ 
			$this->fields[$field]=$value; 
		}
	}
	
	//return an object populated based on the record‘s cate id 
	public static function getById($cate_id){
		$cate=new Category();
		$query=sprintf('SELECT * FROM %scategory WHERE id=%d;',DB_TBL_PREFIX,$cate_id); 
		$result=mysql_query($query,$GLOBALS['DB']);
			
		if(mysql_num_rows($result)){
			$row=mysql_fetch_assoc($result); 
			$cate->id=$row['id'];
			$cate->name=$row['name']; 
			$cate->u_id=$row['u_id']; 
			$cate->u_rank=$row['u_rank'];
		}
		mysql_free_result($result);
		return $cate;
	}

	//从分类id获取分类名
	public static function getNameById($cate_id){
		$query=sprintf('SELECT name FROM %scategory WHERE id=%d;',DB_TBL_PREFIX,$cate_id);
		$result=mysql_query($query,$GLOBALS['DB']);
			
		if(mysql_num_rows($result)){
			$row=mysql_fetch_assoc($result); 
			return $row['name']; 
		}
		mysql_free_result($result);
		return false;
	}
	
	//获得该用户的所有目录信息
	public static function getByUserId3($u_id){
		$query=sprintf('select *,count(c.id) as count from 
(select a.id,name,a.u_id,u_rank,cate_id from article a left join category b on a.cate_id=b.id where a.u_id=%d   
UNION 
select a.id,name,b.u_id,u_rank,cate_id from article a right join category b on a.cate_id=b.id  where b.u_id=%d   )  
c group by cate_id order by u_rank;',
			mysql_real_escape_string($u_id,$GLOBALS['DB']),
			mysql_real_escape_string($u_id,$GLOBALS['DB'])
		);
		$result=mysql_query($query,$GLOBALS['DB']);
		$arr=array();
		while($row=mysql_fetch_assoc($result)){
			$cate=array();
			$cate['id']=$row['id'];
			$cate['name']=$row['name'];
				if($cate['name']==''){$cate['name']='默认分类';}
			$cate['u_id']=$row['u_id'];
			$cate['u_rank']=$row['u_rank'];
			$cate['count']=$row['count'];
			
			//修复分类总数为0时报错
			//$cate['count']=isset($countArr[$row['name']])?$countArr[$row['name']]:0;
			
			$arr[]=$cate;
		}
		mysql_free_result($result);debug($arr);
		return $arr;
	}
	
	//return an object populated based on the record's name 
	public static function getByUserId($u_id){
		//$uid=$_SESSION['uid'];
		//if($u_id!=$uid) return;
		$query=sprintf('SELECT * FROM %scategory WHERE u_id="%s" order by u_rank asc;',DB_TBL_PREFIX,
		mysql_real_escape_string($u_id,$GLOBALS['DB']));
		$result=mysql_query($query,$GLOBALS['DB']); 

		$countArr=self::cateCount($u_id);
		$arr=array();

		while($row=mysql_fetch_assoc($result)){
			$cate=array();
			$cate['id']=$row['id'];
			$cate['name']=$row['name']; 
			$cate['u_id']=$row['u_id']; 
			$cate['u_rank']=$row['u_rank'];
			
			//修复分类总数为0时报错
			$cate['count']=isset($countArr[$row['name']])?$countArr[$row['name']]:0;

			$arr[]=$cate;
		}
		$arr[]=array(
			'id'=>0,
			'name'=>'默认分类',
			'u_id'=>$u_id,
			'u_rank'=>-1,
			'count'=>isset($countArr['默认分类'])?$countArr['默认分类']:0,
			
		);

		mysql_free_result($result);
		return $arr;
	}
	
		
	//按照分类,返回各类别条目数
	public static function cateCount($uid){
		//if($u_id!=$uid) return;
		//'select name,count(id) as count from %sarticle where u_id=%d group by cate_id;',
		$query=sprintf('select b.name,count(a.id) as count from %sarticle a left join %scategory b on a.cate_id=b.id where a.u_id=%d group by a.cate_id;',
			DB_TBL_PREFIX,
			DB_TBL_PREFIX,
			mysql_real_escape_string($uid,$GLOBALS['DB']));
			
		$result=mysql_query($query,$GLOBALS['DB']);
		$arr=array();
		while($row=mysql_fetch_assoc($result)){
			if($row['name']==''){
				$arr['默认分类']=$row['count'];
			}else{
				$arr[$row['name']]=$row['count'];
			}
		}
		return $arr;
	}
	
	//save the record to the database 
	public function save(){
		//update existing user's information 
		if($this->id){
			$query = sprintf('UPDATE %sUSER SET USERNAME = "%s", ' . 
			'PASSWORD = "%s", EMAIL_ADDR = "%s", IS_ACTIVE = %d ' . 
			'WHERE USER_ID = %d', 
			DB_TBL_PREFIX, 
			mysql_real_escape_string($this->username, $GLOBALS['DB']), 
			mysql_real_escape_string($this->password, $GLOBALS['DB']), 
			mysql_real_escape_string($this->emailAddr, $GLOBALS['DB']), 
			$this->isActive, 
			$this->userId); 
			return mysql_query($query, $GLOBALS['DB']); 
		}else{
			//create a new user 
			$query=sprintf('INSERT INTO %sUSER(USERNAME,PASSWORD,' . 
			'EMAIL_ADDR,IS_ACTIVE) VALUES ("%s","%s","%s",%d)', 
			DB_TBL_PREFIX, 
			mysql_real_escape_string($this->username,$GLOBALS['DB']), 
			mysql_real_escape_string($this->password,$GLOBALS['DB']), 
			mysql_real_escape_string($this->emailAddr,$GLOBALS['DB']), 
			$this->isActive); 
			if(mysql_query($query,$GLOBALS['DB'])){ 
				$this->uid=mysql_insert_id($GLOBALS['DB']); 
				return true; 
			}else{
				return false; 
			}
		}
	}
	
	
	//删除一个目录
	static function delete($id,$uid){
		//删除目录
		$query=sprintf('delete from %scategory where u_id=%d and id=%d;', 
		DB_TBL_PREFIX,  
		mysql_real_escape_string($uid,$GLOBALS['DB']), 
		mysql_real_escape_string($id,$GLOBALS['DB']));

		if(mysql_query($query,$GLOBALS['DB'])){
			//再修改文章表中的分类信息为0
			$query2=sprintf('update %sarticle set cate_id=0 where u_id=%d and cate_id=%d;', 
				DB_TBL_PREFIX,
				mysql_real_escape_string($uid,$GLOBALS['DB']), 
				mysql_real_escape_string($id,$GLOBALS['DB']));
			if(mysql_query($query2,$GLOBALS['DB'])){
				return true; 
			}else{
				return false;
			}
		}else{
			return false; 
		}
	}
	//新增一个目录
	static function add($name,$uid){
		//先确定不存在，
		$query=sprintf('select * from %scategory where u_id=%d;', 
		DB_TBL_PREFIX,  
		mysql_real_escape_string($uid,$GLOBALS['DB']));

		$rows=mysql_query($query,$GLOBALS['DB']);
		$num=mysql_affected_rows();
		while($row=mysql_fetch_assoc($rows)){
			//如果存在
			if($row['name']==$name){
				return false;
			}
		}

		//然后再添加
		$query2=sprintf('insert into %scategory(name,u_id,u_rank) values("%s", %d,%d);', 
		DB_TBL_PREFIX,  
		mysql_real_escape_string($name,$GLOBALS['DB']),
		mysql_real_escape_string($uid,$GLOBALS['DB']), 
		++$num);

		if(mysql_query($query2,$GLOBALS['DB'])){
			return true; 
		}else{
			return false; 
		}
	}
	
	//更新目录
	static function update($arr){
		//1.对post数据循环
		$len=count( $arr['id'] );
		$query=sprintf('insert into %scategory(id,name,u_rank) values',DB_TBL_PREFIX);
		for($i=0;$i<$len;$i++){
			//2.组装sql语句
			//$query .= sprintf('update %scategory set name="%s",u_rank=%d where id=%d;',
			$query .= sprintf('( %d,"%s",%d)',
				mysql_real_escape_string($arr['id'][$i],$GLOBALS['DB']),
				mysql_real_escape_string($arr['name'][$i],$GLOBALS['DB']),
				mysql_real_escape_string($arr['u_rank'][$i],$GLOBALS['DB'])
			);
			if($i!=$len-1){
				$query .= ',';
			}else{
				$query .= 'ON DUPLICATE KEY UPDATE name=VALUES(name), u_rank=VALUES(u_rank);';
			}
		}

		mysql_query($query,$GLOBALS['DB']);
		$result=mysql_affected_rows();
		
		if($result>0){
			return true; 
		}else{
			return false; 
		}
	}
	
	
	
	
}