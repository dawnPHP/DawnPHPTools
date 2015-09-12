<?php
/*
实例001：最普通的html+计算题验证码AuthCode1.php
php中：验证码类和实例化。

服务器字段：$_SESSION['AuthCode']
*/

//开启session
session_start();
//接收变量
if(isset($_POST['submit'])){
	$num=$_POST['submit'];
	if($num=="Submit"){
		if(trim($_POST["test"])==$_SESSION['AuthCode']){
			echo'验证码提交成功！<hr>';
		}else{
			echo'<font color="red">111验证码错误！！</font><hr>';
		}
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

 <img src="AuthCode1.php" alt="看不清楚，请换一张" style="cursor:pointer;" onclick="javascript:newgdcode(this,this.src);">
 
 <form method="POST" action="">
     <input type="text" name="test"><br><br><br><br>
    <input type="submit" name="submit" value="Submit">
</form>
 
 
 </body>
</html>