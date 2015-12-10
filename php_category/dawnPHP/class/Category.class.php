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
					//debug($cate_id);
			
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

		$arr=array();
		while($row=mysql_fetch_assoc($result)){
			$cate=new Category();
			
			$cate->id=$row['id']; 
			$cate->name=$row['name']; 
			$cate->u_id=$row['u_id']; 
			$cate->u_rank=$row['u_rank'];
			
			$arr[]=self::toArray($cate);
		}

		mysql_free_result($result);
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
	
	//to array 为什么不能独立出去？
	public static function toArray($obj){
		$_array = is_object($obj)?get_object_vars($obj): $obj;
		$array=array('id'=>$_array['id']);
		$fields=$_array['fields'];
		foreach ($fields as $key => $value) {
			$value = (is_array($value) || is_object($value)) ? self::toArray($value) : $value;
			$array[$key] = $value;
		}
		return $array;
	}
}