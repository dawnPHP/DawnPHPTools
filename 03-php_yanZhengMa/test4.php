<?php
/*
实例04：最普通的html+面向过程验证码。
php中：自定义实现，很简单。

服务器字段：$_SESSION["validationcode"]

*/

//开启session
session_start();
//接收变量
if(isset($_POST['submit'])){
	$num=$_POST['submit'];
	if($num=="Submit"){
		//en不区分大小写
		if(strtolower(trim($_POST["test"]))==strtolower($_SESSION['validationcode'])){
			echo'验证码提交成功！<hr>';
		}else{
			echo'<font color="red">111验证码错误！！</font><hr>';
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

 <img src="AuthCode4.php" alt="看不清楚，请换一张" style="cursor:pointer;" onclick="javascript:newgdcode(this,this.src);">
 
 <form method="POST" action="">
     <input type="text" name="test"><br>
	 <br><br><br>
    <input type="submit" name="submit" value="Submit">
</form>
 
 
 </body>
</html>