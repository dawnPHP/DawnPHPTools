<?php 
namespace utils\db;
/**=============================================
 * MySQL Class
 *
 * 是一个MySQL辅助类
 * 类名时驼峰法，方法名是下划线法。
 *
 * @version		v1.0.0
 * @revise		2017.01.05
 * @date		2017.01.05
 * @author		Dawn
 * @email		JimmyMall@live.com
 * @link		https://github.com/DawnEve/DawnPHPTools
 =============================================*/
class MysqlHelper{
	private $host;
	private $user;
	private $passwd;
	private $conn=null;
	/**
	* 构造函数
	* @param string $rootpath   根目录
	* @return boolean true-检测通过，false-检测失败
	*/
	function __construct($host,$user,$passwd){
		//
		$this->host=$host;
		$this->user=$user;
		$this->passwd=$passwd;
		
		$this->conn = mysql_connect($this->host,$this->user,$this->passwd) or die('Connection error:'.mysql_error());
		mysql_query("set names 'utf8'");//编码
	}
	
	//选择对应数据库
	function select_db($db_database){
		//
		$db_select=mysql_select_db($db_database);
		if( $db_select==false)
			die("DB select error:".mysql_error());
		return  $db_select;
	}
	
	//执行查询之外的curd操作
	function execute($sqlstring){
		//对于curd返回受影响的条数
		//对于查询，返回资源
		mysql_query($sqlstring);
		return mysql_affected_rows();
	}
	
	//执行查询
	function query($sqlstring){
		$result=mysql_query($sqlstring,$this->conn);
		
		$rows=array();
		while($row=mysql_fetch_assoc($result)){
			$rows[]=$row;
		}
		return $rows;
	}
	
	//==============s 更多好用的函数==================
	
	
	/**
	* 记录日志的函数
	* //todo: file_put_contents()用在__destruct中记录失败，why?
	*/
	function log($text){
		//文件记录
		file_put_contents("a.txt","Testing from >>" .$text ."\r\n",FILE_APPEND);
	}
	
	
	
	
	
	
	
	
	
	//==============e 更多好用的函数==================
	
	/**
	*释放资源
	*/
	//function __dedeconstruct(){
	function __destruct (){
		//
		if($this->conn!=null){
			mysql_close($this->conn);
			file_put_contents("a.txt","destroy conn...");
		}
		
		$this->log('destruct');
		print "Destroying " . $this->host . "\n";
	}
}