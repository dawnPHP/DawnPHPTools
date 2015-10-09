<?php
//from http://www.cnblogs.com/Zjmainstay/archive/2012/08/09/jQuery_upload_image.html
    //header('content-type:text/html charset:utf-8');  /* 这句要删除，否则可能会导致IE下回传HTML变成下载 */
    //不存在当前上传文件则上传
	$dir='./zuopin_image/';
    if(!file_exists($_FILES['upload_file']['name'])) move_uploaded_file($_FILES['upload_file']['tmp_name'],$dir . iconv('utf-8','gb2312',$_FILES['upload_file']['name']));
    //输出图片文件<img>标签
    echo "<textarea><img src='". $dir ."{$_FILES['upload_file']['name']}'/></textarea>";
//End_php