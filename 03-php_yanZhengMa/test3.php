<?php
/*
实例03：最普通的html+OOP【中文】验证码类。
php中：支持中英文验证码，厉害

服务器字段：
$sessionName='captchaCode';
$_SESSION[$sessionName]['time']=microtime(); 
$_SESSION[$sessionName]['type']=$type;
$_SESSION[$sessionName]['AuthCode3']=$code;
$_SESSION["captchaCode"]['AuthCode3']=$code;//直接用这个
*/

//开启session
session_start();
//接收变量
if(isset($_POST['submit'])){
	$num=$_POST['submit'];
	if($num=="Submit"){
		//cn直接比较
		if($_SESSION["captchaCode"]['type']=='cn'){
			if(trim($_POST["test"])==$_SESSION["captchaCode"]['AuthCode3']){
				echo'验证码提交成功！<hr>';
			}else{
				echo'<font color="red">111验证码错误！！</font><hr>';
			}		
		//en不区分大小写
		}elseif($_SESSION["captchaCode"]['type']=='en'){
			if(strtolower(trim($_POST["test"]))==strtolower($_SESSION['randcode'])){
				echo'验证码提交成功！<hr>';
			}else{
				echo'<font color="red">111验证码错误！！</font><hr>';
			}
		}
	}else{
		die('Invalid Gateway.');
	}
}
?>

<html>
 <head>
  <title>Image</title>
  <meta http-equiv="content-type" content="text/html;charset=gb2312">
  <script>
   function newgdcode(obj,url){
		obj.src=url+'?nowtime='+new Date().getTime();
   }
  </script>
 </head>


 <body>

 <img src="AuthCode3.php" alt="看不清楚，请换一张" style="cursor:pointer;" onclick="javascript:newgdcode(this,this.src);">
 
 <form method="POST" action="">
     <input type="text" name="test"><br>
	 <br><br><br>
    <input type="submit" name="submit" value="Submit">
</form>
 
 
 </body>
</html>