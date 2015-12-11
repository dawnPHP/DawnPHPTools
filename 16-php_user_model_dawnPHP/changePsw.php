<?php
define("BathPath","D:/xampp/htdocs/php/php_user/dawnPHP/");
include('dawnPHP/mylib.php');


//修改用户密码

$u=User::getByUsername('jack');//update user('jack')
	debug($u,false);
$u->password=sha1('newgogo2');//在这里修改密码
	debug($u,false);
$u->save();//save new jack