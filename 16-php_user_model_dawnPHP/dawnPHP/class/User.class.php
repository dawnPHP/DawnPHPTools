<?php
class User{
	private $uid;
	private $fields;
	
	public function __construct(){
		$this->uid=null; 
		$this->fields=array('username'=>'','password'=>'','emailAddr'=>'','isActive'=>false); 
	}
	
	public function __get($field){
		if($field=='userId'){
			return $this->uid; 
		}else{ 
			return $this->fields[$field]; 
		} 
	}
	
	public function __set($field,$value){
		if(array_key_exists($field,$this->fields)){ 
			$this->fields[$field]=$value; 
		}
	}
	
	//return if username is valid format 
	public static function validateUsername($username){ 
		return preg_match('/^[A-Z0-9]{2,20}$/i',$username); 
	}
	
	//return if email address is valid format 
	public static function validateEmailAddr($email){ 
		return filter_var($email,FILTER_VALIDATE_EMAIL); 
	} 
	//return an object populated based on the record‘s user id 
	public static function getById($user_id){
		$user=new User();
		$query=sprintf('SELECT USERNAME,PASSWORD,EMAIL_ADDR,IS_ACTIVE '. 
		'FROM %sUSER WHERE USER_ID=%d',DB_TBL_PREFIX,$user_id); 
		$result=mysql_query($query,$GLOBALS['DB']); 
		if(mysql_num_rows($result)){
			$row=mysql_fetch_assoc($result); 
			$user->username=$row['USERNAME']; 
			$user->password=$row['PASSWORD']; 
			$user->emailAddr=$row['EMAIL_ADDR']; 
			$user->isActive=$row['IS_ACTIVE']; 
			ChromePhp::log($user_id); 
			$user->uid=$user_id; 
		} 
		mysql_free_result($result); 
		return $user;
	}
	
	//return an object populated based on the record's username 
	public static function getByUsername($username){
		$user=new User(); 
		$query=sprintf('SELECT USER_ID,PASSWORD,EMAIL_ADDR,IS_ACTIVE '. 
		'FROM %sUSER WHERE USERNAME="%s"',DB_TBL_PREFIX,mysql_real_escape_string($username,$GLOBALS['DB'])); 
		$result=mysql_query($query,$GLOBALS['DB']); 
		if(mysql_num_rows($result)){ 
		$row=mysql_fetch_assoc($result); 
		$user->username=$username; 
		$user->password=$row['PASSWORD']; 
		$user->emailAddr=$row['EMAIL_ADDR']; 
		$user->isActive=$row['IS_ACTIVE']; 
		$user->uid=$row['USER_ID']; 
		} 
		mysql_free_result($result); 
		return $user; 
	}
	
	//save the record to the database 
	public function save(){
		//update existing user's information 
		if($this->uid){
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
	
	//set the record as inactive and return an activation token 
	public function setInactive(){
		$this->isActive=false; 
		$this->save();
		$token=random_text(5);
		$query=sprintf('INSERT INTO %sPENDING (USER_ID,TOKEN)' . 
		'VALUES (%d,"%s")',DB_TBL_PREFIX,$this->uid,$token); 
		return (mysql_query($query,$GLOBALS['DB']))?$token:false; 
	}
	
	//clear the user's pending status and set the record as active 
	public function setActive($token){
		$query=sprintf('SELECT TOKEN FROM %sPENDING WHERE USER_ID=%d ' . 
		'AND TOKEN="%s"',DB_TBL_PREFIX,$this->uid,mysql_real_escape_string($token,$GLOBALS['DB']));
		$result=mysql_query($query,$GLOBALS['DB']);
		if(!mysql_num_rows(($result))){
			mysql_free_result($result); 
			return false; 
		}else{
			mysql_free_result($result);
			$query=sprintf('DELETE FROM %sPENDING WHERE USER_ID=%d ' . 
			'AND TOKEN="%s"',DB_TBL_PREFIX,$this->uid,mysql_real_escape_string($token,$GLOBALS['DB']));
			if(!mysql_query($query,$GLOBALS['DB'])){
				return false;
			}else{
				$this->isActive=true;
				return $this->save();
			}
		}
	}
}
?> 