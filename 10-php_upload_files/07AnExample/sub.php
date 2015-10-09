<html>
<head><title>上传结果</title>
<meta charset="utf-8" />
</head>
<body>
<?php

include_once("db.php");


$biaoti=$_POST["biaoti"];
$dtime = date('Y-m-d H:i:s');
$ip= $_SERVER["REMOTE_ADDR"];
$info = $_POST["info"];
$file_name = $_FILES['pic']['name'];//可能是数组或变量
	
//存在文件就上传
for($i=0,$a=0,$b=0;$i<count($file_name);$i++){

	if(!empty($file_name[$i])){
		$b++;
		if(checkPic($i)){
			$a++;
		}
	}
       if(($i+1)==count($file_name)&$a==$b&$a!=0){
		upload();
       }else{
	      // echo '请选择图片';
	       echo "<META HTTP-EQUIV=REFRESH CONTENT='3;URL=online_02.php'>";
       }
}

function checkPic($i){
	global $file_name;

	//检查图片类型
	if($file_name[$i]!=""){
		$ee=explode(".",$file_name[$i]);
		$cc=count($ee)-1;
		$type=strtolower($ee[$cc]);
	}else{
		echo '没有图片';
	}
	if($type!='jpg' and $type!='gif' and $type!='jpeg' and $type!='png'){
		//	echo "type:".$type;
		echo "只能上传jpg或jpge或gif文件";
		echo "<META HTTP-EQUIV=REFRESH CONTENT='3;URL=online_02.php'>";
		exit;
	}
	//检查图片大小
	$size = $_FILES['pic']['size'][$i];

	if($size > 2097152){
		echo "<script>alert('附件大小不能大于2M，请重新输入！'+".$size.");history.go(-1);</script>";
		echo $size;
		exit;
	}
	
    return true;
}
function upload(){
	global $biaoti;
        global $dtime;
        global $ip;
        global $info;
	global $file_name;
	global $DataBase;
	
	for($i=0;$i<count($file_name);$i++){
		//设置上传路径并上传
		$dir="images/zuopin_image/";
	//	echo $file_name[$i];
		if($file_name[$i]!=""){
			$ee=explode(".",$file_name[$i]);
                  	$cc=count($ee)-1;
			$type=strtolower($ee[$cc]);
			
			
			$bb=rand(100000,999999);
			$filename[$i]="_one_".$bb.".".$type;
			$tmp_name[$i]=$_FILES['pic']['tmp_name'][$i];
			$dirname[$i]=$dir.$filename[$i];

			//更新数据库
	
			$query="insert into zuopin (biaoti,filename1,group_id,info,ip,dtime) values ('$biaoti[$i]','$filename[$i]',8,'$info[$i]','$ip','$dtime')";	
		
			mysql_select_db($DataBase) or die('error');
			$result = mysql_query($query);
			if($result){
				$tid=mysql_insert_id();
				move_uploaded_file($tmp_name[$i], $dir.$tid.$filename[$i]); 
				//把上传的照片存到 upload folder 里
				echo '标题：'.$biaoti[$i];
				echo "添加作品成功！<br>";
			}
	    }
	}
}
?>
</body>
</html>