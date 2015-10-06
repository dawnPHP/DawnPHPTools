<?php
/*文件上传
http://www.w3school.com.cn/php/php_file_upload.asp
注意兼容: 对于 IE，识别 jpg 文件的类型必须是 pjpeg，对于 FireFox，必须是 jpeg。
*/

//引入类文件
include('UploadFile.class.php');
include('MyDebug.class.php');


//打印基本信息
MyDebug::p($_FILES);
	/*对于多文件上传，
		需要先使用UploadFile类的静态方法rearrange_files_array重组数组，
		再接着按照单文件上传的方法进行处理。
	*/
//重写file数组
$files=UploadFile::rearrange_files_array($_FILES);

MyDebug::p($files);
MyDebug::p($files['file'][0]); //die();


//文件的限制条件
$restricts=array(
	'size'=>200, //unit: kb
	'type'=>array("image/gif", "image/jpeg", "image/pjpeg", "image/png")
);

//实例化上传对象
$upload1=new UploadFile($files['file'][0]);
MyDebug::p($upload1->get_info());
//执行上传
$r = $upload1->upload_to('./public/images/');


//显示图片
MyDebug::p($r);
if($r[0]==1){
	echo '<img src='.$r[1].' />';
}
?>