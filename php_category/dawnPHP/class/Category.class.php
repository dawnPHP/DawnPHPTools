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

	
	//return an object populated based on the record's name 
	public static function getByUserId($u_id){
		$uid=$_SESSION['uid'];
		//if($u_id!=$uid) return;
		$query=sprintf('SELECT * FROM %scategory WHERE u_id="%s" order by u_rank asc;',DB_TBL_PREFIX,
		mysql_real_escape_string($u_id,$GLOBALS['DB']));
		$result=mysql_query($query,$GLOBALS['DB']); 

		$countArr=self::cateCount($uid);
		
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

		mysql_free_result($result);
		return $arr;
	}
	
	//按照分类,返回各类别条目数
	public static function cateCount($uid){
		//if($u_id!=$uid) return;
		$query=sprintf('select a.name,count(b.id) as count from %scategory a, %sarticle b where b.u_id=%d and b.cate_id=a.id group by b.cate_id;',
			DB_TBL_PREFIX,
			DB_TBL_PREFIX,
			mysql_real_escape_string($uid,$GLOBALS['DB']));
			
		$result=mysql_query($query,$GLOBALS['DB']);
		//select a.name,count(b.id) from category a, article b where b.u_id=2 and b.cate_id=a.id group by b.cate_id;
		$arr=array();
		while($row=mysql_fetch_assoc($result)){
			$arr[$row['name']]=$row['count'];
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
			$query2=sprintf(' update %sarticle set cate_id=0 where u_id=%d and cate_id=%d;', 
				DB_TBL_PREFIX,
				mysql_real_escape_string($id,$GLOBALS['DB']), 
				mysql_real_escape_string($uid,$GLOBALS['DB']));
			if(mysql_query($query,$GLOBALS['DB'])){
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
		mysql_real_escape_string($uid,$GLOBALS['DB']), 
		mysql_real_escape_string($name,$GLOBALS['DB']));

		$rows=mysql_query($query,$GLOBALS['DB']);
		$num=mysql_affected_rows();
		while($row=mysql_fetch_assoc($rows)){
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
	
	
}