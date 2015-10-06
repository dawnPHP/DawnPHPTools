<?php
/*设置编码*/
header("charset=utf-8");

/**
my_upload_files($file,$type="image"){
处理文件上传，并返回关联数组(成功，地址)or（失败，原因）
$file:表单中file控件的名字；
$type:上传的文件类型，默认是image；
*/
function my_upload_files($file,$type="image"){
	$isSuccess=false;
	$info='';

	//上传限制
	switch($type){
		case "image":
			$fileTypes[]="image/gif";
			$fileTypes[]="image/png";
			//对于 IE，识别 jpg 文件的类型必须是 pjpeg，对于 FireFox，必须是 jpeg。
			$fileTypes[]="image/jpeg";
			$fileTypes[]="image/pjpeg";
		break;
		case "text":
			$fileTypes[]="text/plain";
			$fileTypes[]="application/vnd.openxmlformats-officedocument.presentationml.presentation";//pptx
			$fileTypes[]="application/vnd.openxmlformats-officedocument.wordprocessingml.document";//docx
			$fileTypes[]="application/pdf";//pdf
		break;
	}


	if ( in_array($_FILES[$file]["type"], $fileTypes)
	&& ($_FILES[$file]["size"] < 100000000)){
		if ($_FILES[$file]["error"] > 0){
			$info = "Error: " . $_FILES[$file]["error"] . "<br />";
		}else{
			if (file_exists("upload/" . iconv("UTF-8", "GBK", $_FILES[$file]["name"]))){
				$storage="upload/" . $_FILES[$file]["name"];
				$info = $_FILES[$file]["name"] . " already exists. ";	
			}else{
				$storage="upload/" . $_FILES[$file]["name"];
				move_uploaded_file($_FILES['file']['tmp_name'], iconv("UTF-8", "GBK", $storage));
					
				//修改上传的状态
				$isSuccess=true;
				$info=$storage;
			}
		}
	}else{
		$info = "Invalid file~~";
	}
	
	return array($isSuccess,$info);
}

//调用我的上传函数
$wjl=my_upload_files('file');
echo (bool)$wjl[0]."<br>";
echo $wjl[1];
echo "<hr>";
if((bool)$wjl[0]){
	header("location:index.php");
	exit;
	echo "<img src='./{$wjl[1]}' />";
}
?>