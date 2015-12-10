<?php
class Article{
	private $aid;
	private $fields;
	
	public function __construct(){
		$this->aid=null; 
		$this->fields=array('title'=>'','content'=>'','modi_time'=>'','add_time'=>'','u_id'=>'','cate_id'=>''); 
	}
	
	public function __get($field){
		if($field=='aid'){
			return $this->aid; 
		}else{ 
			return $this->fields[$field]; 
		} 
	}
	
	public function __set($field,$value){
		if(array_key_exists($field,$this->fields)){ 
			$this->fields[$field]=$value; 
		}
	}
	
	
	
	//return if Articlename is valid format 
	public static function validateArticlename($Articlename){ 
		return preg_match('/^[A-Z0-9]{2,20}$/i',$Articlename); 
	}
	//return an object populated based on the record‘s Article id 
	public static function getById($Article_id){
		$Article=new Article();
		$query=sprintf('SELECT * FROM %sArticle WHERE aid=%d;',DB_TBL_PREFIX,$Article_id); 
		$result=mysql_query($query,$GLOBALS['DB']); 
			
		if(mysql_num_rows($result)){
			$row=mysql_fetch_assoc($result); 
			$Article->title=$row['title']; 
			$Article->content=$row['content']; 
			$Article->modi_time=$row['modi_time']; 
			$Article->add_time=$row['add_time']; 
			$Article->u_id=$row['u_id']; 
			$Article->cate_id=$row['cate_id'];
			$Article->aid=$Article_id; 
		} 
		mysql_free_result($result);
		return $Article;
	}
	
	//save the record to the database 
	public function save(){
		//update existing Article's information 
		if($this->aid){
			$query = sprintf('UPDATE %sArticle SET title = "%s", ' . 
			'content = "%s", modi_time = "%s", u_id="%s", cate_id="%s"' . 
			'WHERE Article_ID = %d', 
			DB_TBL_PREFIX, 
			mysql_real_escape_string($this->title, $GLOBALS['DB']), 
			mysql_real_escape_string($this->content, $GLOBALS['DB']), 
			time(),
			mysql_real_escape_string($this->u_id, $GLOBALS['DB']), 
			mysql_real_escape_string($this->cate_id, $GLOBALS['DB'])); 
			return mysql_query($query, $GLOBALS['DB']); 
		}else{
			//create a new Article 
			$query=sprintf('INSERT INTO %sArticle(title,content,' . 
			'modi_time,add_time,u_id,cate_id) VALUES ("%s","%s","%s","%s","%s","%s")', 
			DB_TBL_PREFIX, 
			mysql_real_escape_string($this->title, $GLOBALS['DB']), 
			mysql_real_escape_string($this->content, $GLOBALS['DB']), 
			time(),
			time(),
			mysql_real_escape_string($this->u_id, $GLOBALS['DB']), 
			mysql_real_escape_string($this->cate_id, $GLOBALS['DB'])); 
			 
			if(mysql_query($query,$GLOBALS['DB'])){ 
				$this->aid=mysql_insert_id($GLOBALS['DB']); 
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
		$query=sprintf('INSERT INTO %sPENDING (Article_ID,TOKEN)' . 
		'VALUES (%d,"%s")',DB_TBL_PREFIX,$this->aid,$token); 
		return (mysql_query($query,$GLOBALS['DB']))?$token:false; 
	}
	
	//clear the Article's pending status and set the record as active 
	public function setActive($token){
		$query=sprintf('SELECT TOKEN FROM %sPENDING WHERE Article_ID=%d ' . 
		'AND TOKEN="%s"',DB_TBL_PREFIX,$this->aid,mysql_real_escape_string($token,$GLOBALS['DB']));
		$result=mysql_query($query,$GLOBALS['DB']);
		if(!mysql_num_rows(($result))){
			mysql_free_result($result); 
			return false; 
		}else{
			mysql_free_result($result);
			$query=sprintf('DELETE FROM %sPENDING WHERE Article_ID=%d ' . 
			'AND TOKEN="%s"',DB_TBL_PREFIX,$this->aid,mysql_real_escape_string($token,$GLOBALS['DB']));
			if(!mysql_query($query,$GLOBALS['DB'])){
				return false;
			}else{
				$this->isActive=true;
				return $this->save();
			}
		}
	}
	
	
	
	/**
		根据aid更新用户登陆时间为当前时间
	*/
	public static function updateLastLogin($aid){
		//获取时间
		$newTime=time();
		//执行更新
		$query = mysql_query("update Article set lastlogin={$newTime} where aid={$aid};",$GLOBALS['DB']);
		if(mysql_affected_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
		权限：是否可以阅读 todo
		是管理员、作者、或好友，才可以阅读。
		好友还没有实现。
	*/
	function canRead($p_id){
		if($this->Articlegroup ==3 || $this->aid==Article::getById($p_id)){
			return true;
		}
		
		return false;
	}
	
		
	/**
		权限：是否可以修改 todo
		是管理员、作者，才可以阅读。
	*/
	function canEdit($aid){
		if($this->Articlegroup ==3 || $this->aid==Article::getById($p_id)){
			return true;
		}
		
		return false;
	}
	
	
	//获得列表
	public static function getList($uid,$cate_id){
		if($cate_id<1){
			$query=sprintf('select id,title,modi_time,add_time from %sarticle where u_id=%d;',
			DB_TBL_PREFIX,
			mysql_real_escape_string($uid,$GLOBALS['DB']));
		}else{
			$query=sprintf('select id,title,modi_time,add_time from %sarticle where u_id=%d and cate_id=%d;',
			DB_TBL_PREFIX,
			mysql_real_escape_string($uid,$GLOBALS['DB']),
			mysql_real_escape_string($cate_id,$GLOBALS['DB']));
		}
		
		$result=mysql_query($query,$GLOBALS['DB']);
		
		$arr=array();
		while($row=mysql_fetch_assoc($result)){
			$Article=array();
			$Article['id']=$row['id'];
			$Article['title']=$row['title'];
			//$Article['content']=$row['content'];
			//date("Y-m-d H:i:s", time());
			$Article['modi_time']=date("Y-m-d H:i:s", $row['modi_time']);
			$Article['add_time']=date("Y-m-d H:i:s", $row['add_time']);
			$arr[]=$Article;
		}
		mysql_free_result($result);
		return $arr;
	}
}
?> 