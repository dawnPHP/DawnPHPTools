<?php
/*
class Secret{
	static $APPID="xx";
	static $APPSECRET="xxxx";
}
*/
include 'Secret.class.php';
include 'ACC_TOKEN.class.php';
include 'Menu.class.php';
include 'menu_data.php';

$ACC_TOKEN=ACC_TOKEN::get();
print_r( $ACC_TOKEN );
echo '<hr>';

$info=Menu::get($ACC_TOKEN,$data);
print_r( $info );

//{"errcode":48001,"errmsg":"api unauthorized hint: [96DoGa0987vr22]"}