<?php
//from http://www.cnblogs.com/Zjmainstay/archive/2012/08/09/jQuery_upload_image.html
    //header('content-type:text/html charset:utf-8');  /* 这句要删除，否则可能会导致IE下回传HTML变成下载 */
	include('UploadFile.class.php');
	
	$dir='./zuopin_image/';
	
	//重写file数组
	$files=UploadFile::rearrange_files_array($_FILES);
	$files=$files['upload_file'];
	
	
	$img='';
	for($i=0; $i<count( $files ); $i++){
		$file=$files[$i];
		
		//不存在当前上传文件则上传
		if(!file_exists($file['name'])){
			$dst = $dir . iconv('utf-8','gbk',$file['name']);
			move_uploaded_file($file['tmp_name'], $dst );
			
			$dst = $dir . $file['name'];
			$img .= '<img src="'. $dst .'" />';
		}
	}
	
    //输出图片文件<img>标签
    echo '<textarea>'. $img .'</textarea>';
//End_php