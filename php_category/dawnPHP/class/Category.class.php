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

		$countArr=self::cateCount($uid,$row['id']);
		
		$arr=array();
		while($row=mysql_fetch_assoc($result)){
			$cate=array();
			$cate['id']=$row['id'];
			$cate['name']=$row['name']; 
			$cate['u_id']=$row['u_id']; 
			$cate['u_rank']=$row['u_rank'];
			
			$cate['count']=$countArr[$row['name']];
			
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
}