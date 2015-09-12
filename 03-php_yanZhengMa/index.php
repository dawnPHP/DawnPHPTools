<?php
session_start();
if(isset($_POST['submit'])){
	$num=$_POST['submit'];
	if($num=="Submit1"){
		if(trim($_POST["test"])==$_SESSION['AuthCode']){
			echo'111提交成功！<hr>';
		}else{
			echo'<font color="red">111验证码错误！！</font><hr>';
		}

	}else{
		if(trim($_POST["test"])==$_SESSION['validationcode']){
			echo'222提交成功！<hr>';
		}else{
			echo'<font color="red">222验证码错误！！</font><hr>';
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
 <form method="POST" action="index.php">
     <input type="text" name="test"><br>
    <input type="submit" name="submit" value="Submit1">
</form>
 
 <hr>
 
 <img src="AuthCode4.php" alt="看不清楚，请换一张" style="cursor:pointer;" onclick="javascript:newgdcode(this,this.src);">
   <form method="POST" action="index.php">
    <input type="text" name="test"><br>
    <input type="submit" name="submit" value="Submit2">
   </form>
 </body>

</html>