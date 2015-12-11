<?php
define("BathPath","D:/xampp/htdocs/php/php_user/dawnPHP/");
include('dawnPHP/mylib.php');

echo '<link rel="stylesheet" type="text/css" href="' . $publicPath . 'css/main.css">';
//添加新用户

//create user instance 
$u=new User();
$u->username='jimmy'; 
$u->password=sha1('gogo'); 
$u->emailAddr='jimmymall@163.com'; 
$u->save();//save this user
	debug($u);
?>