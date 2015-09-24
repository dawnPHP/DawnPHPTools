<h1>二维码生成</h1>
<style>
input{padding:10px; margin:10px;}
#box{color:red; width:1000px;}

</style>

<form action="index.php" method="GET">
<?php if(isset($_GET['value'])){?>
value:<input type=text name=value id=box  value=<?php echo $_GET['value'];?>><br>
<?php }else{ ?>
value:<input type=text name=value id=box value="http://fireCloudPHP.blog.163.com"><br>
<?php } ?>


size: <select name=size>
		<option>1</option>
		<option>2</option>
		<option>3</option>
		<option>4</option>
		<option>5</option>
		<option selected>6</option>
		<option>7</option>
		<option>8</option>
		<option>9</option>
		<option>10</option>
	</select><br>
	<input type=submit name=sub value='submit'>
</form>
<?php
	$value='http://fireCloudPHP.blog.163.com';
	$matrixPointSize=5; //生成图片大小   
if(isset($_GET['value'])){
	$value=$_GET['value'];
}
if(isset($_GET['size'])){
	$matrixPointSize=$_GET['size'];
}



	include './phpqrcode/phpqrcode.php'; 
	$errorCorrectionLevel = 'L';//容错级别     
	//生成二维码图片   
	QRcode::png($value, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);  
	echo "<img src='qrcode.png' />";
?>
