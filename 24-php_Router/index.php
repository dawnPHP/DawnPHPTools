<?php 
// 项目根路径
define('BASEPATH', dirname(__FILE__));
//你的域名.com是你的服务器域名  
define('SITE_ROOT' , 'http://你的域名.com');  

include 'config.php';
include 'function.php';




/*
测试路由
*/

//demo1.目的：测试几个常见url获取和处理方法
//include 'demo1.php';
/*
http://localhost/DawnPHPTools/24-php_Router/Article/index/id/2007
http://localhost/DawnPHPTools/24-php_Router/Article/show/tag/apple/id/2017?cat=good
*/

//demo2.基本功能，1.地址分发，2.url生成U('User/index',array('id'=>12))
include 'demo2.php';

//更多测试在demo2.php中。