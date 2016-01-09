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
	public function save22(){
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
	
	
	//获得文章列表
	public static function getList($uid,$cate_id){
		if($cate_id==-1){
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
	
	//Article::change_cate($o_id,$n_id,$a_id);
	//改变条目的目录
	public static function change_cate($arr){
		//1.获取数据
		$o_id=$arr['o_id'];
		$n_id=$arr['n_id'];
		$a_ids=$arr['id'];

		//2.组装sql语句
		$len=count( $a_ids );
		$query=sprintf('insert into %sarticle(id,cate_id) values',DB_TBL_PREFIX);
		
		for($i=0;$i<$len;$i++){
			$query .= sprintf('( %d,%d)',
			mysql_real_escape_string($a_ids[$i],$GLOBALS['DB']),
			mysql_real_escape_string($n_id,$GLOBALS['DB'])
			);
			if($i!=$len-1){
				$query .= ',';
			}else{
				$query .= 'ON DUPLICATE KEY UPDATE  cate_id=VALUES(cate_id);';
			}
		}
		//debug($query);
		//3.执行
		mysql_query($query,$GLOBALS['DB']);
		$result=mysql_affected_rows();
		if($result>0){
			return true; 
		}else{
			return false; 
		}
	}
	
	//Article::add($o_id,$n_id,$a_id);
	//新建条目
	public static function add($uid,$title,$content,$cate_id,$tags){
		//1.获取时间
		$add_time=time();
		//2.执行更新Article表
		$query=sprintf('insert into %sarticle(title,content,add_time,u_id,cate_id) values("%s","%s",%d,%d,%d);',
			DB_TBL_PREFIX,
			mysql_real_escape_string($title,$GLOBALS['DB']),
			mysql_real_escape_string($content,$GLOBALS['DB']),
			mysql_real_escape_string($add_time,$GLOBALS['DB']),
			mysql_real_escape_string($uid,$GLOBALS['DB']),
			mysql_real_escape_string($cate_id,$GLOBALS['DB'])
		);

		$result = mysql_query($query, $GLOBALS['DB']);
		if($result){
			$a_id=mysql_insert_id();
			
			//处理标签
			if($tags!=''){
				return Tags::add($tags,$uid,$a_id);
			}
			return $a_id;
		}else{
			return false;
		}
	}
	
	//更新条目
	public static function save($id,$uid,$title,$content,$cate_id,$tags){
		//1.获取时间
		$modi_time=time();
		//2.执行更新Article表
		$query=sprintf('update %sarticle set title="%s",content="%s",modi_time=%d,cate_id=%d where id=%d and u_id=%d;',
			DB_TBL_PREFIX,
			mysql_real_escape_string($title,$GLOBALS['DB']),
			mysql_real_escape_string($content,$GLOBALS['DB']),
			$modi_time,
			mysql_real_escape_string($cate_id,$GLOBALS['DB']),
			mysql_real_escape_string($id,$GLOBALS['DB']),
			mysql_real_escape_string($uid,$GLOBALS['DB'])
		);

		$result = mysql_query($query, $GLOBALS['DB']);
		if($result){
			$a_id=$id;
			
			//处理标签
			if($tags!=''){
				return Tags::add($tags,$uid,$a_id);
			}
			return $a_id;
		}else{
			return false;
		}
	}
	
	//删除条目
	public static function delete($uid,$a_id){
		//1.执行删除Article表的条目
		$query=sprintf('delete from %sarticle where u_id=%d and id=%d;',
			DB_TBL_PREFIX,
			mysql_real_escape_string($uid,$GLOBALS['DB']),
			mysql_real_escape_string($a_id,$GLOBALS['DB'])
		);
		
		mysql_query($query, $GLOBALS['DB']);
		if(mysql_affected_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	//获取条目详细信息
	public static function detail($uid,$a_id){
		$arr=array();
		//1.执行查询Article表的条目
		$query=sprintf('select * from %sarticle where  id=%d;',
			//u_id=%d and
			DB_TBL_PREFIX,
			//mysql_real_escape_string($uid,$GLOBALS['DB']),
			mysql_real_escape_string($a_id,$GLOBALS['DB'])
		);
		
		$result=mysql_query($query, $GLOBALS['DB']);
		//主体信息
		$row=mysql_fetch_assoc($result);
		//如果是空集，直接返回空数组
		if($row==false){
			$row = array();
		}else{
			$row['add_time']=date("Y-m-d H:i:s", $row['add_time']);
			if($row['modi_time']!=''){
				$row['modi_time']=date("Y-m-d H:i:s", $row['modi_time']);
			}
			//获取分类信息
			$row['cate_name']=Category::getNameById($row['cate_id']);
		}

		//返回主体信息
		$arr[]=$row;
		mysql_free_result($result);
		
		
		//获取上文信息；
		$query=sprintf('select id,title from %sarticle where u_id=%d and id<%d order by id DESC limit 1;',
			DB_TBL_PREFIX,
			mysql_real_escape_string($uid,$GLOBALS['DB']),
			mysql_real_escape_string($a_id,$GLOBALS['DB'])
		);
		$result=mysql_query($query, $GLOBALS['DB']);
		$row=mysql_fetch_assoc($result);

		$arr[]=$row;
		mysql_free_result($result);
		
		//获取下文信息；
		$query2= sprintf('select id,title from %sarticle where u_id=%d and id>%d order by id ASC limit 1;',
			DB_TBL_PREFIX,
			mysql_real_escape_string($uid,$GLOBALS['DB']),
			mysql_real_escape_string($a_id,$GLOBALS['DB'])
		);
		$result=mysql_query($query2, $GLOBALS['DB']);
		$row=mysql_fetch_assoc($result);

		$arr[]=$row;
		mysql_free_result($result);
		
		//返回数组
		return $arr;
	}
}
?> 