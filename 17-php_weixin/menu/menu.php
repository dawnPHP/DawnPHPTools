<?php
define("BathPath","D:/xampp/htdocs/php/DawnPHPTools/17-php_weixin/DawnPHP/");
include('../dawnPHP/mylib.php');

//============================
// 1.添加菜单不成功时，请清除config.txt文件，再试。
// 2.新添加的菜单24小时后才会看到效果，快速更新界面的方式：取消关注，再重新关注。
//============================

//执行微信菜单的添加、删除（没有实现）功能
//菜单数据
include 'menu_data.php';

//获取ACC_TOKEN
$ACC_TOKEN=ACC_TOKEN::get();
print_r( $ACC_TOKEN );
echo '<hr>';

//添加菜单
$info=Menu::add($ACC_TOKEN,$data);
print_r( $info );

/*Array
(
    [access_token] => 9lIBRRkLUPB9xG5urYWcs-_wAHA8mtqriMHzH1f0syOw2Tp3KyhQjCIkpwU9DaXtpr1FI6Ubc2d8awtfwlSQnhkwJbPZZyR8NYlLqxcvgr8UGBfAFAGSN
    [expires_in] => 7200
)
9lIBRRkLUPB9xG5urYWcs-_wAHA8mtqriMHzH1f0syOw2Tp3KyhQjCIkpwU9DaXtpr1FI6Ubc2d8awtfwlSQnhkwJbPZZyR8NYlLqxcvgr8UGBfAFAGSN
{"errcode":48001,"errmsg":"api unauthorized hint: [tjhB70411vr21]"}
*/

//因为没有花300元验证，所以没有菜单权限。
//{"errcode":48001,"errmsg":"api unauthorized hint: [96DoGa0987vr22]"}